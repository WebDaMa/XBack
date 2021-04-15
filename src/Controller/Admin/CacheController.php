<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController
{
    /**
     * @Route("/cache", name="cache")
     */
    public function index()
    {
        $dir = dirname(__DIR__, 2);
        exec("php ". $dir ."/bin/console cache:clear --env=prod");

        return $this->render('cache/index.html.twig', [
            'controller_name' => 'CacheController',
        ]);
    }
}
