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
     * @RequestParam(name="missing", description="test", nullable=true)
     * @RequestParam(name="white", description="test", nullable=true)
     * @RequestParam(name="black", description="test", nullable=true)
     * @RequestParam(name="wrong", description="test", nullable=true)
     * @RequestParam(name="double_fault", description="test", nullable=true)
     * @RequestParam(name="line_4", description="test", nullable=true)
     * @RequestParam(name="line_5", description="test", nullable=true)
     * @RequestParam(name="line_6", description="test", nullable=true)
     * @RequestParam(name="victory", description="test", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     */
    public function patchPlayerAction(ParamFetcher $paramFetcher, int $id)
    {
        $params = [];
        foreach ($paramFetcher->all() as $criterionName => $criterionValue) {
            $params[$criterionName] = $criterionValue;
        }

        $player = $this->playerRepository->findOneBy(['id' => $id]);

        if ($player) {
            $player->setWhite($params['missing']);
            $player->setWhite($params['white']);
            $player->setBlack($params['black']);
            $player->setWhite($params['wrong']);
            $player->setWhite($params['double_fault']);
            $player->setWhite($params['line_4']);
            $player->setWhite($params['line_5']);
            $player->setWhite($params['line_6']);
            $player->setWhite($params['victory']);

            $this->entityManager->persist($player);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }

}
