<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Matche;
use App\Entity\Player;
use App\Repository\GameRepository;
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

    /**
     *
     * @return void
     */
    public function getGamesAction()
    {
        $games = $this->gameRepository->findAll();

        $filteredGames = [];

        foreach ($games as $game) {
            $filteredGames[] = [
                "id" => $game->getId(),
                "matcheId" => $game->getMatche()->getId(),
                "matcheFinished" => $game->getMatche()->getIsFinished(),
                "userFirstId" => $game->getMatche()->getUserFirst()->getId(),
                "userFirstName" => $game->getMatche()->getUserFirst()->getName(),
                "userSecondId" => $game->getMatche()->getUserSecond()->getId(),
                "userSecondName" => $game->getMatche()->getUserSecond()->getName(),
                "gameFinished" => $game->getIsFinished(),
                "created" => $game->getCreatedAt(),
                "updated" => $game->getUpdatedAt(),
            ];
        }

        return $this->view($filteredGames, Response::HTTP_OK);
    }

    public function getGameAction(int $id)
    {
        $game = $this->gameRepository->findOneBy(['id' => $id]);

        $filteredGame = [
            "id" => $game->getId(),
            "matcheId" => $game->getMatche()->getId(),
            "player1" => [
                "id" => $game->getPlayers()[0]->getId(),
                "userName" => $game->getPlayers()[0]->getUser()->getName(),
            ],
            "player2" => [
                "id" => $game->getPlayers()[1]->getId(),
                "userName" => $game->getPlayers()[1]->getUser()->getName(),
            ],
            "created" => $game->getCreatedAt(),
            "updated" => $game->getUpdatedAt(),
        ];

        return $this->view($filteredGame, Response::HTTP_OK);
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
            $oldMatche = $this->entityManager->getRepository('App:Matche')->findOneBy(['id' => $match_id]);
            $game->setMatche($oldMatche);
            $game->setIsFinished(false);

            $first = $oldMatche->getUserFirst();
            $second = $oldMatche->getUserSecond();

            $entityUserFirst = $this->entityManager->getRepository('App:User')->findOneBy(['id' => $first]);
            $entityUserSecond = $this->entityManager->getRepository('App:User')->findOneBy(['id' => $second]);

            $player1 = new Player();
            $player1->setName('player-1');
            $player1->setGame($game);
            $player1->setUser($entityUserFirst);

            $player2 = new Player();
            $player2->setName('player-2');
            $player2->setGame($game);
            $player2->setUser($entityUserSecond);

            $this->entityManager->persist($game);
            $this->entityManager->persist($player1);
            $this->entityManager->persist($player2);
            $this->entityManager->flush();

            return $this->view($game, Response::HTTP_CREATED);
        }

        return $this->view('error', Response::HTTP_BAD_REQUEST);
    }

     /**
     * @RequestParam(name="isFinished", description="test", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     */
    public function patchGameAction(ParamFetcher $paramFetcher, int $id)
    {
        $isFinished = $paramFetcher->get('isFinished');
        $game = $this->gameRepository->findOneBy(['id' => $id]);

        if ($game) {
            $game->setIsFinished($isFinished);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }
}
