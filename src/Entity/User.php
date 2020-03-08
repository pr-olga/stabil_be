<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Matche", mappedBy="matche")
     * @ORM\JoinColumn(nullable=true)
     */
    private $matche;

    /**
     * One User can have many players
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="user")
     */
    private $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->matche = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setUser($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getUser() === $this) {
                $player->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Matche[]
     */
    public function getMatche(): Collection
    {
        return $this->matche;
    }

    public function addMatche(Matche $matche): self
    {
        if (!$this->matche->contains($matche)) {
            $this->matche[] = $matche;
            $matche->setMatche($this);
        }

        return $this;
    }

    public function removeMatche(Matche $matche): self
    {
        if ($this->matche->contains($matche)) {
            $this->matche->removeElement($matche);
            // set the owning side to null (unless already changed)
            if ($matche->getMatche() === $this) {
                $matche->setMatche(null);
            }
        }

        return $this;
    }

}
