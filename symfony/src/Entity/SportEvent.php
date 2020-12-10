<?php

namespace App\Entity;

use App\Repository\SportEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportEventRepository::class)
 */
final class SportEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $competition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCompetition(): ?string
    {
        return $this->competition;
    }

    public function setCompetition(string $competition): self
    {
        $this->competition = $competition;

        return $this;
    }
}
