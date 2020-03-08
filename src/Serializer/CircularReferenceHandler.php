<?php
use App\Entity\Player;
use Symfony\Component\Routing\RouterInterface;

namespace App\Serializer;

class CircularReferenceHandler
{

    private $router;

    public function __contruct (RouterInterface $router){
        $this->router = $router;
    }

    public function __invoke($object)
    {
        switch ($object) {
            case $object instanceof Player:
                $this->router->generate('get_players', ['player' => $object->getId()]);
            default:
                # code...
                break;
        }
        return $object->getId();
    }
}
