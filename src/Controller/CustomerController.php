<?php

namespace App\Controller;

use App\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * @Route("/customer", name="customer")
     */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $customer = new Customer();
        $customer->setBooker('Ceulemans_Arjen');
        $customer->setFirstName('Arjen');
        $customer->setLastName('Ceulemans');
        $customer->setBirthdate(\DateTime::createFromFormat('d/m/Y', '11/06/1990'));
        $customer->setEmail('arjenceulemans@hotmail.com');
        $customer->setGsm('0032474297413');
        $customer->setNationalRegisterNumber('591-3004760-93');
        $customer->setExpireDate(\DateTime::createFromFormat('d/m/y', '18/03/16'));
        $customer->setSize('M');
        $customer->setNameShortage('AC');
        $customer->setLicensePlate('N/A');
        $customer->setEmergencyNumber('123456789');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($customer);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new customer with id '.$customer->getId());
    }

    /**
     * @Route("/customer/{id}", name="customer_show")
     */
    public function showAction(Customer $customer)
    {

        if (!$customer) {
            throw $this->createNotFoundException(
                'No customer found for.'
            );
        }

        return new Response('Check out this great customer: '.$customer->getBooker());

    }

    /**
     * @Route("/customer/edit/{id}")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw $this->createNotFoundException(
                'No customer found for id '.$id
            );
        }

        $customer->setBooker('Ceulemans_Arjen!');
        $em->flush();

        return $this->redirectToRoute('customer_show', [
            'id' => $customer->getId()
        ]);
    }
}
