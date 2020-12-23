<?php

namespace App\Entity;

use App\Repository\EncounterEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EncounterEventRepository::class)
 */
final class EncounterEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=SportType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private SportType $sportType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSportType(): SportType
    {
        return $this->sportType;
    }

    public function setSportType(SportType $sportType): self
    {
        $this->sportType = $sportType;

        return $this;
    }

    //TODO::Ajouter la relation SportEvent
}
