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
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern = "/^\w['\w -]{2,}$/u"
     * )
     */
    private string $teamName;

    /**
     * @ORM\ManyToMany(targetEntity=SportEvent::class, mappedBy="sportTeamList")
     *
     * @var Collection<int, SportEvent>
     */
    private Collection $sportEventsList;

    /**
     * @ORM\ManyToMany(targetEntity=Athlete::class, inversedBy="sportTeamsList")
     *
     * @var Collection<int, Athlete>
     */
    private Collection $athleteList;


    public function __construct()
    {
        $this->sportEventsList = new ArrayCollection();
        $this->athleteList = new ArrayCollection();
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
    public function getSportEventsList(): Collection
    {
        return $this->sportEventsList;
    }

    public function addSportEventsList(SportEvent $sportEventsList): self
    {
        if (!$this->sportEventsList->contains($sportEventsList)) {
            $this->sportEventsList[] = $sportEventsList;
            $sportEventsList->addSportTeamList($this);
        }

        return $this;
    }

    public function removeSportEventsList(SportEvent $sportEventsList): self
    {
        if ($this->sportEventsList->removeElement($sportEventsList)) {
            $sportEventsList->removeSportTeamList($this);
        }

        return $this;
    }

    /** @return Collection<int, Athlete> */
    public function getAthleteList(): Collection
    {
        return $this->athleteList;
    }

    public function addAthleteList(Athlete $athleteList): self
    {
        if (!$this->athleteList->contains($athleteList)) {
            $this->athleteList[] = $athleteList;
        }

        return $this;
    }

    public function removeAthleteList(Athlete $athleteList): self
    {
        $this->athleteList->removeElement($athleteList);

        return $this;
    }
}
