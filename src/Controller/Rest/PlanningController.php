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

        $activity = $request->get('activity');
        $guideId = $request->get('guideId');
        $cag1Id = $request->get('cag1Id');
        $cag2Id = $request->get('cag2Id');
        $transport = $request->get('transport');

        if ($planning) {
            $planning->setActivity($activity);

            $rep = $this->getDoctrine()->getRepository(Guide::class);
            if(!empty($guideId)) {
                $guide = $rep->find($guideId);
                if($guide) {
                    $planning->setGuide($guide);
                }
            }

            if(!empty($cag1Id)) {
                $cag1 = $rep->find($cag1Id);
                if($cag1) {
                    $planning->setCag1($cag1);
                }
            }

            if(!empty($cag2Id)) {
                $cag2 = $rep->find($cag2Id);
                if($cag2) {
                    $planning->setCag2($cag2);
                }
            }

            $planning->setTransport($transport);

            $planning->setUpdatedBy($this->getUser());
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($planning);
            $dm->flush();

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

        $view = $this->view([
            "message" => "No planning was found!",
        ], Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }
}