<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartpageController extends AbstractController
{
    /**
     * Show the list of admins
     *
     * @Route("/", name="startpage")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
