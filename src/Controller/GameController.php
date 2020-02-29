<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractFOSRestController
{

    private $gameRepository;
    private $entityManager;

    public function __construct(GameRepository $gameRepository, EntityManagerInterface $entityManager)
    {
        $this->gameRepository = $gameRepository;
        $this->entityManager = $entityManager;
    }

    public function getGamesAction()
    {
        $data = $this->gameRepository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    public function getGameAction(int $id)
    {
        $game = $this->gameRepository->findOneBy(['id' => $id]);
        return $this->view($game, Response::HTTP_OK);
    }
}
