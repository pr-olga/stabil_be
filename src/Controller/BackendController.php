<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend", name="backend.")
 */
class BackendController extends AbstractController
{
    /**
     * Show the list of admins
     *
     * @Route("/", name="index")
     */
    public function index(AdminRepository $adminRepository)
    {
       $admins = $adminRepository->findAll();

        return $this->render('backend/index.html.twig', [
            'admins' => $admins
        ]);

    }

    /**
     * Show single admin
     *
     * @Route("/admin/{id?}", name="admin")
     *
     * @param Admin $admin
     * @return Response
     */
    public function showAdmin(Admin $admin)
    {
        return $this->render('backend/admin.html.twig', [
            'admin' => $admin
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
    public function createAdmin(Request $request)
    {
  /*       $admin = new Admin();

        $admin->setAdminname('Olga2');
        $admin->setEmail('olga3@test.de');
        $admin->setPassword('123456789');
        $admin->setApikey('123456789');

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return new Response('new Admin was created'); */
        return $this->render('backend/create.html.twig', [
            'admin_name' => 'test'
        ]);
    }

    /**
     * Remove Admin
     *
     * @Route("/remove/{id?}", name="remove")
     *
     * @param Admin $admin
     * @return Response
     */
    public function removeAdmin(Admin $admin)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($admin);
        $em->flush();

        $this->addFlash('success', 'Admin was removed');

        return $this->redirect($this->generateUrl('backend.index'));
    }

}
