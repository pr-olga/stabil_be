<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

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
     * @RequestParam(name="white", description="test", nullable=true)
     * @RequestParam(name="black", description="test", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     */
    public function patchPlayerAction(ParamFetcher $paramFetcher, int $id)
    {
        $params = [];
        foreach ($paramFetcher->all() as $criterionName => $criterionValue) {
            $params[$criterionName] = $criterionValue;
        }

        $game = $this->playerRepository->findOneBy(['id' => $id]);

        if ($game) {
            $game->setWhite($params['white']);
            $game->setBlack($params['black']);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }

    /**
     * @RequestParam(name="name")
     * @param ParamFetcher $paramFetcher
     */
    /* public function postPlayerAction(ParamFetcher $paramFetcher)
    {
    $name = $paramFetcher->get('name');

    if ($name) {
    $player = new Player();
    $player->setName($name);

    $this->entityManager->persist($player);
    $this->entityManager->flush();

    return $this->view($player, Response::HTTP_CREATED);
    }

    return $this->view($player, Response::HTTP_BAD_REQUEST);

    } */

}
