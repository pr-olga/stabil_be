<?php

namespace App\Controller;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StartpageController extends AbstractController
{
    /**
     * Show the list of admins
     *
     * @Route("/", name="startpage")
     */
    public function index(LoggerInterface $logger)
    {
        $logger->log(
            Logger::WARNING, 'seite ist aufgerufen'
        );

        return $this->render('index.html.twig');
    }
}
