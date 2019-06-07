<?php


namespace App\Controller\Rest;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/user/roles")
     */
    public function getRolesAction() {
        $roles = $this->getUser()->getRoles();
        $view = $this->view($roles, Response::HTTP_OK);

        return $this->handleView($view);
    }

}