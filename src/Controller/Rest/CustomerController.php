<?php


namespace App\Controller\Rest;


use App\Entity\Customer;
use App\Entity\SuitSize;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends FOSRestController {
    private $cusRep;

    /**
     * CustomerController constructor.
     * @param $cusRep
     */
    public function __construct()
    {
        $this->cusRep = $this->getDoctrine()->getRepository(Customer::class);
    }


    /**
     * @Rest\Get("/customers/groep/{groepId}")
     */
    public function getAllByGroepAction($groepId): Response {
        $rep = $this->cusRep;
        $data = $rep->getAllByGroepId($groepId);
        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/customers/suitsize/{customerId}")
     */
    public function putCustomerSizeAction($customerId, Request $request): Response
    {
        $rep = $this->cusRep;
        $customer = $rep->find($customerId);
        $sizeRep = $this->getDoctrine()->getRepository(SuitSize::class);
        $size = $sizeRep->find((int) $request->get('size'));
        if ($customer) {
            if($size) {
                $customer->setSize($size);
            }
            $customer->setSizeInfo($request->get('sizeInfo'));
            $dm = $this->getDoctrine()->getManager();
            $dm->persist($customer);
            $dm->flush();
        }
        // In case our PUT was a success we need to return a 200 HTTP OK response with the object as a result of PUT
        $view = $this->view($customer, Response::HTTP_OK);

        return $this->handleView($view);
    }
}