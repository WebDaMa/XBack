<?php


namespace App\Controller\Rest;


use App\Entity\Agency;
use App\Entity\Groep;
use App\Logic\Calculations;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class AgencyController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/agencies/week-and-location/{date}/{locationId}")
     */
    public function getAllAgenciesForWeekAndLocationAction($date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(Agency::class);

        //Make periodId
        $periodId = Calculations::generatePeriodFromDate($date);

        $data = $rep->getAllByPeriodAndLocation($periodId, $locationId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}