<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
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
     * @RequestParam(name="white", description="test", nullable=true)
     * @RequestParam(name="black", description="test", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     */
    public function patchGameAction(ParamFetcher $paramFetcher, int $id)
    {
        $params = [];
        foreach ($paramFetcher->all() as $criterionName => $criterionValue) {
            $params[$criterionName] = $criterionValue;
        }

        $game = $this->gameRepository->findOneBy(['id' => $id]);

        if ($game) {
            $game->setWhite($params['white']);
            $game->setBlack($params['black']);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }
}
