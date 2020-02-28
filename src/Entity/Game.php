<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Game
{

   use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player_1;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player_2;

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
     * @ORM\Column(type="integer")
     */
    private $victory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Match", inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $match;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1(): ?Player
    {
        return $this->player_1;
    }

    public function setPlayer1(Player $player_1): self
    {
        $this->player_1 = $player_1;

        return $this;
    }

    public function getPlayer2(): ?Player
    {
        return $this->player_2;
    }

    public function setPlayer2(Player $player_2): self
    {
        $this->player_2 = $player_2;

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

    public function getMatch(): ?Match
    {
        return $this->match;
    }

    public function setMatch(?Match $match): self
    {
        $this->matches = $matches;

        return $this;
    }
}
