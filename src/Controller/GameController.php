<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\MatcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
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

    /**
     * @RequestParam(name="matche")
     * @param ParamFetcher $paramFetcher
     */
    public function postGameAction(ParamFetcher $paramFetcher)
    {
        $match_id = $paramFetcher->get('matche');

        if ($match_id) {
            $game = new Game();
            $oldMAtche = $this->entityManager->getRepository('App:Matche')->findOneBy(['id' => $match_id]);
            $game->setMatche($oldMAtche);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view($game, Response::HTTP_CREATED);
        }

        return $this->view('error', Response::HTTP_BAD_REQUEST);
    }
}
