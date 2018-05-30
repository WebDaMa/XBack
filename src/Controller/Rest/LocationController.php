<?php


namespace App\Controller\Rest;


use App\Entity\Location;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends FOSRestController {

    /**
     * @Rest\Get("/locations")
     */
    public function getLocationsAction() {
        $data = $this->getDoctrine()->getRepository(Location::class)->findAllRaw();
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}