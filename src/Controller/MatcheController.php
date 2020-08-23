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

        $filteredMatches = [];

        foreach ($data as $match) {

            $gamesId = [];
            foreach ($match->getGames() as $game) {
                $gamesId[] = $game->getId();
            }

            $filteredMatches[] = [
                "id" => $match->getId(),
                "matchFinished" => $match->getIsFinished(),
                "userFirstId" => $match->getUserFirst()->getId(),
                "userFirstName" => $match->getUserFirst()->getName(),
                "userSecondId" => $match->getUserSecond()->getId(),
                "userSecondName" => $match->getUserSecond()->getName(),
                "games" => [
                    "ids" => $gamesId
                ],
                "created" => $match->getCreatedAt(),
                "updated" => $match->getUpdatedAt(),
            ];
        }

        return $this->view($filteredMatches, Response::HTTP_OK);
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

    /**
     * @RequestParam(name="isFinished", description="test", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @param integer $id
     */
    public function patchMatcheAction(ParamFetcher $paramFetcher, int $id)
    {
        $isFinished = $paramFetcher->get('isFinished');
        $matche = $this->matcheRepository->findOneBy(['id' => $id]);

        if ($matche) {
            $matche->setIsFinished($isFinished);

            $this->entityManager->persist($matche);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view("error", Response::HTTP_BAD_REQUEST);
    }
}
