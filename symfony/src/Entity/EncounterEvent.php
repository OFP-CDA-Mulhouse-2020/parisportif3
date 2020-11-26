<?php

namespace App\Entity;

use App\Repository\EncounterEventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EncounterEventRepository::class)
 */
class EncounterEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SportType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $sportType;

    /**
     * @ORM\ManyToOne(targetEntity=SportEvent::class, inversedBy="encoounterEvent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sportEvent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSportType(): ?SportType
    {
        return $this->sportType;
    }

    public function setSportType(?SportType $sportType): self
    {
        $this->sportType = $sportType;

        return $this;
    }

    public function getSportEvent(): ?SportEvent
    {
        return $this->sportEvent;
    }

    public function setSportEvent(?SportEvent $sportEvent): self
    {
        $this->sportEvent = $sportEvent;

        return $this;
    }
}
