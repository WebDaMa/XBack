<?php


namespace App\Controller\Rest;


use App\Entity\Guide;
use App\Entity\Planning;
use App\Logic\Calculations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanningController extends FOSRestController {

    /**
     * @Rest\Get("/planning/{date}/{locationId}")
     */
    public function getAllByDayAndLocationAction($date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Planning::class);

        $date = new \DateTime($date);
        $data = $rep->findByLocationIdAndDate($locationId, $date);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/planning/{guideId}/{date}/{locationId}")
     */
    public function getAllByGuideAndWeekAndLocationAction($guideId ,$date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Planning::class);

        $date = new \DateTime($date);
        $data = $rep->findByGuideIdAndLocationIdAndDate($guideId, $locationId, $date);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/planning/{planningId}")
     */
    public function putPlanningUpdateAction($planningId, Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(Planning::class);
        $planning = $rep->find($planningId);

        if ($planning) {
            $planning->setActivity($request->get('activity'));
            $rep = $this->getDoctrine()->getRepository(Guide::class);
            $guide = $rep->find($request->get('guideId'));
            $planning->setGuide($guide);

            $cag1 = $rep->find($request->get('cag1Id'));
            $planning->setCag1($cag1);

            $cag2 = $rep->find($request->get('cag2Id'));
            $planning->setCag2($cag2);

            $transport = $rep->find($request->get('transport'));
            $planning->setTransport($transport);

            $planning->setUpdatedBy($this->getUser());
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($planning);
            $dm->flush();
        }

        $guideShort = "";

        if(isset($guide)) {
            $guideShort = $guide->getGuideShort();
        }

        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view([
            "id" => $planning->getId(),
            "guide" => $guideShort,
            "activity" => $planning->getActivity()
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }
}