<?php

namespace App\Entity;

use App\Repository\SportTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportTypeRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("name")
 */
final class SportType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern= "/^(?:\p{L}{2,}|E)(?:[ '-]\p{L}+)*$/u"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     */
    private int $nbrOfActiveAthlete;

    /**
     * @var Collection<int, SportEvent>
     *
     * @ORM\OneToMany(targetEntity=SportEvent::class, mappedBy="sportType")
     */
    private Collection $sportEventsList;


    public function __construct()
    {
        $this->sportEventsList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): ?self
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrOfActiveAthlete(): ?int
    {
        return $this->nbrOfActiveAthlete;
    }

    public function setNbrOfActiveAthlete(int $nbrOfActiveAthlete): self
    {
        $this->nbrOfActiveAthlete = $nbrOfActiveAthlete;

        return $this;
    }

    /** @return Collection<int, SportEvent> */
    public function listSportEvents(): Collection
    {
        return $this->sportEventsList;
    }

    public function addSportEvent(SportEvent $newSportEvent): self
    {
        if (!$this->sportEventsList->contains($newSportEvent)) {
            $this->sportEventsList[] = $newSportEvent;
            $newSportEvent->setSportType($this);
        }

        return $this;
    }
}
