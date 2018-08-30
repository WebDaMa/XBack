<?php


namespace App\Controller\Rest;


use App\Entity\Groep;
use App\Logic\Calculations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class GroepController extends FOSRestController {

    /**
     * @Rest\Get("/groeps/week-and-location/{date}/{locationId}")
     */
    public function getAllGroepsForWeekAndLocationAction($date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Groep::class);

        $periodId = Calculations::generatePeriodFromDate($date);

        $data = $rep->getAllByPeriodAndLocation($periodId, $locationId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

}