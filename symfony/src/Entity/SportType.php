<?php

namespace App\Entity;

use App\Repository\SportTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportTypeRepository::class)
 */
class SportType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameType;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrAthleteActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameType(): ?string
    {
        return $this->nameType;
    }

    public function setNameType(string $nameType): self
    {
        $this->nameType = $nameType;

        return $this;
    }

    public function getNbrAthleteActive(): ?int
    {
        return $this->nbrAthleteActive;
    }

    public function setNbrAthleteActive(int $nbrAthleteActive): self
    {
        $this->nbrAthleteActive = $nbrAthleteActive;

        return $this;
    }
}
