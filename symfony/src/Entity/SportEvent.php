<?php

namespace App\Entity;

use App\Repository\SportEventRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportEventRepository::class)
 */
final class SportEvent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $maxDate = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $maxDate->add(new DateInterval('P2D'));

        $this->date = $date;

        return $this;
    }
}
