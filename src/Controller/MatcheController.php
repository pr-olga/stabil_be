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
     * @RequestParam(name="userFirst")
     * @RequestParam(name="userSecond")
     * @param ParamFetcher $paramFetcher
     */
    public function postMatcheAction(ParamFetcher $paramFetcher)
    {
        $userFirst = $paramFetcher->get('userFirst');
        $userSecond = $paramFetcher->get('userSecond');

        if (($userFirst && $userSecond) && ($userFirst !== $userSecond)) {
            $entityUserFirst = $this->entityManager->getRepository('App:User')->findOneBy(['id' => $userFirst]);
            $entityUserSecond = $this->entityManager->getRepository('App:User')->findOneBy(['id' => $userSecond]);

            $matche = new Matche();
            $matche->setIsFinished(false);
            $matche->setUserFirst($entityUserFirst);
            $matche->setUserSecond($entityUserSecond);

            $this->entityManager->persist($matche);
            $this->entityManager->flush();

            return $this->view($matche, Response::HTTP_CREATED);
        }

        return $this->view('error', Response::HTTP_BAD_REQUEST);
    }
}
