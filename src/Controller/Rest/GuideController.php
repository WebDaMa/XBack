<?php


namespace App\Controller\Rest;


use App\Entity\Guide;
use App\Entity\Location;
use App\Logic\Calculations;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class GuideController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/guide/{guideShort}")
     */
    public function getAction(string $guideShort) {
        $rep = $this->getDoctrine()->getRepository(Guide::class);
        $data = $rep->getIdByGuideShort($guideShort);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/guides/week-and-location/{date}/{locationId}")
     */
    public function getAllGuidesForWeekAndLocationAction($date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Guide::class);
        $period = Calculations::generatePeriodFromDate($date);
        $data = $rep->getAllByPeriodAndLocation($period, $locationId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}