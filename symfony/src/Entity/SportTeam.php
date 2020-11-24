<?php

namespace App\Entity;

use App\Repository\SportTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportTeamRepository::class)
 */
class SportTeam
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
    private $teamName;

    /**
     * @ORM\ManyToMany(targetEntity=Athlete::class, inversedBy="sportTeams")
     */
    private $athlete;

    /**
     * @ORM\ManyToMany(targetEntity=SportEvent::class)
     */
    private $sportEvent;

    public function __construct()
    {
        $this->athlete = new ArrayCollection();
        $this->sportEvent = new ArrayCollection();
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

    /**
     * @return Collection|Athlete[]
     */
    public function getAthlete(): Collection
    {
        return $this->athlete;
    }

    public function addAthlete(Athlete $athlete): self
    {
        if (!$this->athlete->contains($athlete)) {
            $this->athlete[] = $athlete;
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        $this->athlete->removeElement($athlete);

        return $this;
    }

    /**
     * @return Collection|SportEvent[]
     */
    public function getSportEvent(): Collection
    {
        return $this->sportEvent;
    }

    public function addSportEvent(SportEvent $sportEvent): self
    {
        if (!$this->sportEvent->contains($sportEvent)) {
            $this->sportEvent[] = $sportEvent;
        }

        return $this;
    }

    public function removeSportEvent(SportEvent $sportEvent): self
    {
        $this->sportEvent->removeElement($sportEvent);

        return $this;
    }

}
