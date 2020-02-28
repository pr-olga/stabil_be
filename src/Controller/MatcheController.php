<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\MatcheRepository;
use App\Entity\Matche;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class MatcheController extends AbstractFOSRestController
{

    private $matcheRepository;
    private $entityManager;

    public function __construct(MatcheRepository $matcheRepository, EntityManagerInterface $entityManager)
    {
        $this->matcheRepository = $matcheRepository;
        $this->entityManager = $entityManager;
    }

    public function getMatchesAction()
    {
        $data = $this->matcheRepository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    public function getMatcheAction(int $id)
    {

    }

    public function getMatchesGamesAction(int $id)
    {

    }

    public function postMatcheAction()
    {
        $matche = new Matche();
        $matche->addGame();
    }

}
