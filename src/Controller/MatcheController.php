<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Repository\MatcheRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @RequestParam()
     * @param ParamFetcher $paramFetcher
     */
    public function postMatcheGameAction(ParamFetcher $paramFetcher, int $id)
    {
        $matche = $this->matcheRepository->findByOne(['id' => $id]);

        if ($matche) {
            $game = new Game();
            $matche->addGame($game);

            $this->entityManager->persist($game);
            $this->entityManager->flush();

            return $this->view($game, Response::HTTP_CREATED);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }

}
