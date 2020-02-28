<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RequestParamInterface;
use FOS\RestBundle\Request\ParamFetcher;
use App\Repository\GameRepository;
use App\Entity\Game;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

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

    }

    /**
     * @RequestParam(name="white", description="white sunk", nullable=true)
     * @param ParamFetcher $paramFetcher
     */
    public function postGamesAction(ParamFetcher $paramFetcher)
    {
        $white = $paramFetcher->get('white');

        if ($white) {
            $game = new Game();

            $game->setWhite($white);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view($game, Response::HTTP_CREATED);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);

    }

}
