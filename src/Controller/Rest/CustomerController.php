<?php


namespace App\Controller\Rest;


use App\Entity\Customer;
use App\Entity\SuitSize;
use App\Entity\TravelType;
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
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $customer->getId(),
            "size" => $customer->getSize()->getId(),
            "sizeInfo" => $customer->getSizeInfo()
        ], Response::HTTP_OK);

        return $this->handleView($view);
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
     * @Rest\Get("/customers/bus/go/{date}")
     */
    public function getBusGoCustomersByWeek($date): Response {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $data = $rep->getBusGoCustomersByWeek($date);
        $view = $this->view($data, Response::HTTP_OK);

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
}