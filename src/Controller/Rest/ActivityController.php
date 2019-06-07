<?php


namespace App\Controller\Rest;


use App\Entity\Activity;
use App\Entity\ActivityGroup;
use App\Entity\Groep;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/activities/groups")
     */
    public function getAllGroupsAction() {
        $rep = $this->getDoctrine()->getRepository(ActivityGroup::class);
        $data = $rep->findAllRaw();
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/activities/{activityGroupId}")
     */
    public function getAllActivitiesByActivityGroupIdCategoryAction($activityGroupId) {
        $rep = $this->getDoctrine()->getRepository(Activity::class);
        $data = $rep->findAllByActivityGroupId($activityGroupId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

}