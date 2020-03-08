<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Player
{

    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $missing;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $white;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $black;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wrong;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $double_fault;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $line_4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $line_5;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $line_6;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $victory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="players")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMissing(): ?int
    {
        return $this->missing;
    }

    public function setMissing(?int $missing): self
    {
        $this->missing = $missing;

        return $this;
    }

    public function getWhite(): ?int
    {
        return $this->white;
    }

    public function setWhite(?int $white): self
    {
        $this->white = $white;

        return $this;
    }

    public function getBlack(): ?int
    {
        return $this->black;
    }

    public function setBlack(?int $black): self
    {
        $this->black = $black;

        return $this;
    }

    public function getWrong(): ?int
    {
        return $this->wrong;
    }

    public function setWrong(?int $wrong): self
    {
        $this->wrong = $wrong;

        return $this;
    }

    public function getDoubleFault(): ?int
    {
        return $this->double_fault;
    }

    public function setDoubleFault(?int $double_fault): self
    {
        $this->double_fault = $double_fault;

        return $this;
    }

    public function getLine4(): ?int
    {
        return $this->line_4;
    }

    public function setLine4(?int $line_4): self
    {
        $this->line_4 = $line_4;

        return $this;
    }

    public function getLine5(): ?int
    {
        return $this->line_5;
    }

    public function setLine5(?int $line_5): self
    {
        $this->line_5 = $line_5;

        return $this;
    }

    public function getLine6(): ?int
    {
        return $this->line_6;
    }

    public function setLine6(?int $line_6): self
    {
        $this->line_6 = $line_6;

        return $this;
    }

    public function getVictory(): ?int
    {
        return $this->victory;
    }

    public function setVictory(int $victory): self
    {
        $this->victory = $victory;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
