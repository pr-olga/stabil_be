<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    /**
     * Show the list of admins
     *
     * @Route("/backend", name="backend")
     */
    public function index()
    {
        return $this->render('backend/index.html.twig', [
            'controller_name' => 'BackendController',
        ]);

    }

    /**
     * Show single admin
     *
     * @Route("/backend/{admin?}", name="admin")
     *
     * @param Request $request
     * @return Response
     */
    public function admin(Request $request)
    {
        $name = $request->get('admin');

        return $this->render('backend/admin.html.twig', [
            'admin_name' => $name
        ]);
    }

}
