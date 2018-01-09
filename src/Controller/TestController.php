<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    /**
     * @Route("admin/test", name="test")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('dashboard/index.html.twig');
    }
}
