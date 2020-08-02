<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/backend", name="backend.")
 */
class BackendController extends AbstractController
{
    /**
     * Show the list of admins
     *
     * @Route("/", name="index")
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
     * @Route("/admins/{admin?}", name="admins")
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

    /**
     * Create admin
     *
     * @Route("/create", name="create")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $admin = new Admin();

        $admin->setAdminname('Olga');
        $admin->setEmail('olga2@test.de');
        $admin->setPassword('12345678');
        $admin->setApikey('12345678');

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return new Response('new Admin was created');
    }

}
