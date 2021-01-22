<?php

namespace App\Entity;

use App\Repository\SportTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportTeamRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("teamName")
 */
final class SportTeam
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
     *     pattern = "/^\w['\w -]{2,}$/u"
     * )
     */
    private string $teamName;

    /**
     * @var Collection<int, SportEvent>
     *
     * @ORM\ManyToMany(targetEntity=SportEvent::class, mappedBy="sportTeamList")
     *
     * @TODO Valider avec un callback
     */
    private Collection $sportEventsList;

    /**
     * @var Collection<int, Athlete>
     *
     * @ORM\ManyToMany(targetEntity=Athlete::class, inversedBy="sportTeamsList")
     *
     * @TODO Valider avec un callback
     */
    private Collection $athletesList;


    public function __construct()
    {
        $this->sportEventsList = new ArrayCollection();
        $this->athletesList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

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
            $newSportEvent->addSportTeam($this);
        }

        return $this;
    }

    /** @return Collection<int, Athlete> */
    public function listAthletes(): Collection
    {
        return $this->athletesList;
    }

    public function addAthlete(Athlete $newAthlete): self
    {
        if (!$this->athletesList->contains($newAthlete)) {
            $this->athletesList[] = $newAthlete;
        }

        return $this;
    }

    public function removeAthlete(Athlete $removedAthlete): self
    {
        $this->athletesList->removeElement($removedAthlete);

        return $this;
    }
}
