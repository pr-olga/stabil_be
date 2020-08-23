<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractFOSRestController
{

    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function getUsersAction()
    {
        $users= $this->userRepository->findAll();

        $filteredUsers = [];

        foreach ($users as $user) {
            $players = [];
            foreach ($user->getPlayers() as $player) {
                $players[] = [
                    "id" => $player->getId(),
                    "victory" => $player->getVictory()
                ];
            }

            $filteredGames[] = [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "players" => [
                    $players
                ],
                "created" => $user->getCreatedAt(),
                "updated" => $user->getUpdatedAt(),
            ];
        }

        return $this->view($filteredUsers, Response::HTTP_OK);
    }

    public function getUserAction(int $id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $players = [];
        foreach ($user->getPlayers() as $player) {
            $players[] = [
                "id" => $player->getId(),
                "victory" => $player->getVictory(),
                "whites" => $player->getWhite(),
                "blacks" => $player->getBlack()
            ];
          }

        $filteredUser = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "players" => [
                $players
            ],
            "created" => $user->getCreatedAt(),
            "updated" => $user->getUpdatedAt()
        ];

        return $this->view($filteredUser, Response::HTTP_OK);
    }

    /**
     * @RequestParam(name="name")
     * @param ParamFetcher $paramFetcher
     */
    public function postUserAction(ParamFetcher $paramFetcher)
    {
        $name = $paramFetcher->get('name');

        if ($name) {
          $user = new User();
          $user->setName($name);

          $this->entityManager->persist($user);
          $this->entityManager->flush();

          return $this->view($user, Response::HTTP_CREATED);
        }

        return $this->view('error', Response::HTTP_BAD_REQUEST);
    }
}
