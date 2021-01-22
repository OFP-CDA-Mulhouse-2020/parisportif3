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
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private string $competitionName;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\Timezone
     */
    private string $timeZone;

    /**
     * @ORM\ManyToOne(targetEntity=SportType::class, inversedBy="sportEventsList")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid
     */
    private SportType $sportType;

    /**
     * @var Collection<int, SportTeam>
     *
     * @ORM\ManyToMany(targetEntity=SportTeam::class, inversedBy="sportEventsList")
     * @ORM\JoinColumn(nullable=false)
     *
     * @TODO Valider avec un callback
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

    public function getCompetitionName(): string
    {
        return $this->competitionName;
    }

    public function setCompetitionName(string $competitionName): self
    {
        $this->competitionName = $competitionName;

        return $this;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @TODO Rendre la timezone dynamique, et gérer l'exception
     * @throws Exception
     */
    public function setDate(DateTimeInterface $date): self
    {
        $minDate = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $minDate->add(new DateInterval('P2D'));


        if ($date >= $minDate) {
            $this->date = $date;
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
