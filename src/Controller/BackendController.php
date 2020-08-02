<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    /**
     * @Route("/backend", name="backend")
     */
    public function index()
    {
        return $this->render('backend/index.html.twig', [
            'controller_name' => 'BackendController',
        ]);
    }
}
