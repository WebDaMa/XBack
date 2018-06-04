<?php


namespace App\Controller\Rest;


use App\Entity\Groep;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class GroepController extends FOSRestController {

    /**
     * @Rest\Get("/groeps-for-week-and-location/{date}/{locationId}")
     */
    public function getAllGroepsForWeekAndLocationAction($date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Groep::class);
        $data = $rep->getAllByPeriodAndLocation($date, $locationId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}