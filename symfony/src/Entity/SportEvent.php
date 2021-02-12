<?php

namespace App\Entity;

use App\Repository\SportEventRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportEventRepository::class)
 * @UniqueEntity("id")
 * @TODO Un évènement sportif est t'il unique? et si oui sous quel critère ?
 */
final class SportEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $competition;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $datet;

    /**
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\NotBlank
     * @Assert\Timezone
     */
    private string $timeZone;

    /**
     * @var Collection<int, SportType>
     * @ORM\ManyToOne(targetEntity=SportType::class, inversedBy="sportEventsList")
     * @ORM\JoinColumn(nullable=false)
     */
    private SportType $sportType;

    /**
     * @var Collection<int, SportTeam>
     *
     * @ORM\ManyToMany(targetEntity=SportTeam::class, inversedBy="sportEventsList")
     * @ORM\JoinColumn(nullable=false)
     */
    private Collection $sportTeamList;


    public function __construct()
    {
        $this->sportTeamList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCompetition(): string
    {
        return $this->competition;
    }

    public function setCompetition(string $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getDatet(): DateTimeInterface
    {
        return $this->datet;
    }

    /**
     * @TODO Rendre la timezone dynamique, et gérer l'exception
     * @throws Exception
     */
    public function setDatet(DateTimeInterface $date): self
    {
        $minDate = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $minDate->add(new DateInterval('P2D'));


        if ($date >= $minDate) {
            $this->datet = $date;
        }

        return $this;
    }

    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = $timeZone;

        return $this;
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

    /** @return Collection<int, SportTeam> */
    public function listSportTeams(): Collection
    {
        return $this->sportTeamList;
    }

    public function addSportTeam(SportTeam $newTeam): self
    {
        if (!$this->sportTeamList->contains($newTeam)) {
            $this->sportTeamList[] = $newTeam;
        }

        return $this;
    }

    public function removeSportTeam(SportTeam $removedTeam): self
    {
        $this->sportTeamList->removeElement($removedTeam);

        return $this;
    }
}
