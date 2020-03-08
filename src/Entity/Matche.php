<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatcheRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Matche
{

    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="matche")
     */
    private $games;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFinished;

     /**
     * One Match has one first User.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matche")
     */
    private $userFirst;

     /**
     * One Match has one second User.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matche")
     */
    private $userSecond;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->userFirst = new ArrayCollection();
        $this->userSecond = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(?bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setMatche($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getMatche() === $this) {
                $game->setMatche(null);
            }
        }

        return $this;
    }

    public function getUserFirst(): ?User
    {
        return $this->userFirst;
    }

    public function setUserFirst(?User $userFirst): self
    {
        $this->userFirst = $userFirst;

        return $this;
    }

    public function getUserSecond(): ?User
    {
        return $this->userSecond;
    }

    public function setUserSecond(?User $userSecond): self
    {
        $this->userSecond = $userSecond;

        return $this;
    }


}
