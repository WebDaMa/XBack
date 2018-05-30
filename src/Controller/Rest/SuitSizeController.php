<?php


namespace App\Controller\Rest;


use App\Entity\Guide;
use App\Entity\Location;
use App\Entity\SuitSize;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class SuitSizeController extends FOSRestController {

    /**
     * @Rest\Get("/suitsize/total/{guideId}/{date}")
     */
    public function getTotalForGuideAndDateAction($guideId, $date) {
        $rep = $this->getDoctrine()->getRepository(SuitSize::class);
        $data = $rep->findSuitSizesFullFromDateAndGuide($date, $guideId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}