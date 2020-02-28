<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use App\Repository\PlayerRepository;
use App\Entity\Player;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class PlayerController extends AbstractFOSRestController
{

    private $playerRepository;
    private $entityManager;

    public function __construct(PlayerRepository $playerRepository, EntityManagerInterface $entityManager)
    {
        $this->playerRepository = $playerRepository;
        $this->entityManager = $entityManager;
    }

    public function getPlayersAction()
    {
        $data = $this->playerRepository->findAll();
        return $this->view($data, Response::HTTP_OK);
    }

    public function getPlayerAction(int $id)
    {

    }


    /**
     * @RequestParam(name="name", description="name of player", nullable=false)
     * @param ParamFetcher $paramFetcher
     */
    public function postPlayerAction(ParamFetcher $paramFetcher)
    {
        $player = $paramFetcher->get('name');

        if ($player) {
            $player = new Player();

            $player->setName($name);

            $this->entityManager->persist($player);
            $this->entityManager->flush();

            return $this->view($player, Response::HTTP_CREATED);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);

    }


}
