<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\MatcheRepository;

class MatcheController extends AbstractFOSRestController
{

    private $matcheRepository;

    public function __construct(MatcheRepository $matcheRepository)
    {
        $this->matcheRepository = $matcheRepository;
    }

    public function getMatchesAction()
    {
        return $this->matcheRepository->findAll();
    }

    public function getMatcheAction(int $id)
    {

    }

    public function getMatchesGamesAction(int $id)
    {

    }

    public function postMatcheAction()
    {

    }

}
