<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Entity\Player;
use App\Entity\Game;
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

    /**
     * @RequestParam(name="is_finished")
     * @param ParamFetcher $paramFetcher
     */
    public function postMatcheAction(ParamFetcher $paramFetcher)
    {
        $is_finished = $paramFetcher->get('is_finished');

        if ($is_finished) {
            $matche = new Matche();
            $matche->setIsFinished(false);

            $this->entityManager->persist($matche);
            $this->entityManager->flush();

            return $this->view($matche, Response::HTTP_CREATED);
        }

        return $this->view('error', Response::HTTP_BAD_REQUEST);
    }
}
