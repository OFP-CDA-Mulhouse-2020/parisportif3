<?php

namespace App\Entity;

use App\Repository\SportEventRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportEventRepository::class)
 * @TODO Un évènement sportif est unique, il ne peu en avoir 2 avec le même nom et la même année
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
     */
    private string $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $competition;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\NotBlank
     * @Assert\Timezone
     */
    private string $timeZone;

    //TODO Ajouter la relation avec SportType

    //TODO Ajouter la relation avec SportTeam


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /** @TODO Rendre la timezone dynamique, et gérer l'exception */
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
}
