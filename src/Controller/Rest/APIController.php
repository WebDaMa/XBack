<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

//Global functions

class APIController extends FOSRestController
{
    /**
     * @Rest\Get("/hello")
     */
    public function getAction(Request $request)
    {
        $data = ["hello" => "world"];
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}
