<?php


namespace App\Controller\Rest;


use App\Entity\SuitSize;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class SuitSizeController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/suitsize/total/{guideId}/{date}/{locationId}")
     */
    public function getTotalForGuideDateAndLocationAction($guideId, $date, $locationId) {
        $rep = $this->getDoctrine()->getRepository(SuitSize::class);
        $data = $rep->findSuitSizesFullFromDateAndGuide($date, $guideId, $locationId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/suitsizes")
     */
    public function getAllAction() {
        $rep = $this->getDoctrine()->getRepository(SuitSize::class);
        $data = $rep->findAllRaw();
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}