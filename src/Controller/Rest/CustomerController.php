<?php


namespace App\Controller\Rest;


use App\Entity\Activity;
use App\Entity\Customer;
use App\Entity\SuitSize;
use App\Entity\TravelType;
use App\Logic\Calculations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends FOSRestController {

    /**
     * @Rest\Get("/customers/groep/{groepId}")
     */
    public function getAllByGroepAction($groepId): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByGroepId($groepId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/suitsize/{customerId}")
     */
    public function putCustomerSizeAction($customerId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $rep = $this->getDoctrine()->getRepository(SuitSize::class);
        $size = $rep->find((int) $request->get('size'));
        if ($customer) {
            if($size) {
                $customer->setSize($size);
            }
            $customer->setSizeInfo($request->get('sizeInfo'));
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();

            $view = $this->view([
                "id" => $customer->getId(),
                "size" => $customer->getSize()->getId(),
                "sizeInfo" => $customer->getSizeInfo()
            ], Response::HTTP_OK);
        }else{
            $view = $this->view([
                "id" => 0,
                "size" => 0,
                "sizeInfo" => ""
            ], Response::HTTP_OK);
        }

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT


        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/rafting/{customerId}")
     */
    public function putCustomerRaftingOptionAction($customerId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $rep = $this->getDoctrine()->getRepository(Activity::class);
        $activity = $rep->find((int) $request->get('activityId'));
        if ($customer && $activity && $activity->getActivityGroup()->getName() == "raft") {
            $customer->addActivity($activity);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();

            $view = $this->view([
                "id" => $customer->getId(),
                "activityId" => $activity->getId(),
                "sizeInfo" => $customer->getSizeInfo()
            ], Response::HTTP_OK);
        }else{
            // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
            $view = $this->view([
                "id" => 0,
                "activityId" => 0,
                "sizeInfo" => ""
            ], Response::HTTP_OK);
        }

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/canyoning/{customerId}")
     */
    public function putCustomerCanyoningOptionAction($customerId, Request $request): Response
    {
        list($customer, $activities) = $this->putCustomerOptionsAction($customerId, "canyon", $request);
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "activityIds" => implode(",", $activities),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/special/{customerId}")
     */
    public function putCustomerSpecialOptionAction($customerId, Request $request): Response
    {
        list($customer, $activities) = $this->putCustomerOptionsAction($customerId, "special", $request);
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "activityIds" => implode(",", $activities),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    private function putCustomerOptionsAction($customerId, $activityOptionName, Request $request) {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $rep = $this->getDoctrine()->getRepository(Activity::class);
        $activities = explode(",", $request->get('activityIds'));
        foreach ($activities as $activityId) {
            $activity = $rep->find($activityId);

            if ($customer && $activity && $activity->getActivityGroup()->getName() === $activityOptionName)
            {
                $customer->addActivity($activity);
                $dm = $this->getDoctrine()->getManager();
                $dm->persist($customer);
                $dm->flush();
            }
        }
        return [$customer, $activities];
    }

    /**
     * @Rest\Get("/customers/groep/rafting/{groepId}")
     */
    public function getAllByGroepWithRaftingOptionAction($groepId): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByGroepIdWithRaftingOption($groepId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/groep/canyoning/{groepId}")
     */
    public function getAllByGroepWithCanyoningOptionAction($groepId): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByGroepIdWithCanyoningOption($groepId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/groep/special/{groepId}")
     */
    public function getAllByGroepWithSpecialOptionAction($groepId): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByGroepIdWithSpecialOption($groepId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/bus/go/{date}")
     */
    public function getBusGoCustomersByWeek($date): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getBusGoCustomersByWeek($date);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/bus/go/{customerId}")
     */
    public function putBusGoCustomerCheckAction($customerId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $check = (bool) $request->get('busCheckedIn');
        if ($customer) {
            $customer->setBusToCheckedIn($check);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "check" => $customer->getBusToCheckedIn(),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/bus/back/{date}")
     */
    public function getBusBackCustomersByWeek($date): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getBusBackCustomersByWeek($date);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/bus/back/{customerId}")
     */
    public function putBusBackCustomerCheckAction($customerId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $check = (bool) $request->get('busCheckedIn');
        if ($customer) {
            $customer->setBusBackCheckedIn($check);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "check" => $customer->getBusBackCheckedIn(),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/lodging/layout/{customerId}")
     */
    public function putLodgingLayoutCustomerAction($customerId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $rep->find($customerId);
        $lodgingLayout = $request->get('lodgingLayout');
        if ($customer) {
            $customer->setLodgingLayout($lodgingLayout);
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "lodgingLayout" => $customer->getLodgingLayout(),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/lodging/{agencyId}/{locationId}/{date}")
     */
    public function getAllByAgencyForLodgingAndPeriodAndLocationAction($agencyId, $locationId, $date): Response {
        $periodId = Calculations::generatePeriodFromDate($date);

        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByAgencyForLodgingAndLocationAndPeriod($agencyId, $locationId, $periodId);

        $res = [
            "date" => Calculations::getLastSaturdayFromDate($date),
            "customers" => $data
        ];

        $view = $this->view($res, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/customers/all-in-type/{locationId}/{date}")
     */
    public function getAllByAllInTypeForLocationAndPeriodAction($locationId, $date): Response {
        $periodId = Calculations::generatePeriodFromDate($date);

        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getAllByAllInTypeForLocationAndPeriod($locationId, $periodId);

        $data["date"] = Calculations::getLastSaturdayFromDate($date);

        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}