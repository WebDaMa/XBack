<?php


namespace App\Controller\Rest;


use App\Entity\Guide;
use App\Entity\Location;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class GuideController extends FOSRestController {

    /**
     * @Rest\Get("/guide/{guideShort}")
     */
    public function getAction($guideShort) {
        $rep = $this->getDoctrine()->getRepository(Guide::class);
        $data = $rep->getIdByGuideShort($guideShort);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}