<?php

namespace App\Entity;

use App\Repository\SportEventRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportEventRepository::class)
 */
class SportEvent
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
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competition;

    /**
     * @ORM\Column(type="datetime_immutable_utc")
     */
    private $datetimeUtc;

    /**
     * @ORM\Column(type="string")
     */
    private $timezone;

    /**
     * @ORM\OneToMany(targetEntity=SportType::class, mappedBy="sportEvent")
     */
    private $sportType;

    /**
     * @ORM\OneToMany(targetEntity=EncounterEvent::class, mappedBy="sportEvent", orphanRemoval=true)
     */
    private $encounterEvent;

    public function __construct()
    {
        $this->sportType = new ArrayCollection();
        $this->encounterEvent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

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

    public function setLocalDateTime(DateTimeImmutable $dateTime): void
    {
        $dateTimeUtc = $dateTime->setTimezone(new DateTimeZone('UTC'));

        $this->datetimeUtc = $dateTimeUtc;
        $this->timezone = $dateTime->getTimezone()->getName();
    }

    public function getLocalDateTime(): DateTimeImmutable
    {
        $timestampUtc = $this->datetimeUtc->getTimestamp();

        return DateTimeImmutable::create('@' . $timestampUtc, new DateTimeZone($this->timezone));
    }

    public function getDateTimeUtc(): DateTimeImmutable
    {
        return $this->datetimeUtc;
    }

    /**
     * @return Collection|SportType[]
     */
    public function getSportType(): Collection
    {
        return $this->sportType;
    }

    public function addSportType(SportType $sportType): self
    {
        if (!$this->sportType->contains($sportType)) {
            $this->sportType[] = $sportType;
        }

        return $this;
    }

    public function removeSportType(SportType $sportType): self
    {
        // set the owning side to null (unless already changed)
        if ($this->sportType->removeElement($sportType) && $sportType->getSportEvent() === $this) {
            $sportType->setSportEvent(null);
        }

        return $this;
    }

    /**
     * @return Collection|EncounterEvent[]
     */
    public function getEncounterEvent(): Collection
    {
        return $this->encounterEvent;
    }

    public function addEncounterEvent(EncounterEvent $encounterEvent): self
    {
        if (!$this->encounterEvent->contains($encounterEvent)) {
            $this->encounterEvent[] = $encounterEvent;
            $encounterEvent->setSportEvent($this);
        }

        return $this;
    }

    public function removeEncounterEvent(EncounterEvent $encounterEvent): self
    {
        if ($this->encounterEvent->removeElement($encounterEvent) && $encounterEvent->getSportEvent() === $this) {
            $encounterEvent->setSportEvent(null);
        }

        return $this;
    }
}
