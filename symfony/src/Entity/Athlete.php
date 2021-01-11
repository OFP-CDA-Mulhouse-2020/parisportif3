<?php

namespace App\Entity;

use App\Repository\AthleteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AthleteRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity({"lastName", "firstName"})
 */
final class Athlete
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
     *      pattern = "/^\p{L}{2,}(?:[' -]\p{L}+)*$/u"
     * )
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern = "/^\p{L}{2,}(?:['-]\p{L}+)*$/u"
     * )
     */
    private string $firstName;

    /**
     * @ORM\ManyToMany(targetEntity=SportTeam::class, mappedBy="athleteList")
     *
     * @var Collection<int, SportTeam>
     */
    private Collection $sportTeamsList;

    public function __construct()
    {
        $this->sportTeamsList = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /** @return Collection<int, SportTeam> */
    public function getSportTeamsList(): Collection
    {
        return $this->sportTeamsList;
    }

    public function addSportTeamsList(SportTeam $sportTeamsList): self
    {
        if (!$this->sportTeamsList->contains($sportTeamsList)) {
            $this->sportTeamsList[] = $sportTeamsList;
            $sportTeamsList->addAthleteToList($this);
        }

        return $this;
    }

    public function removeSportTeamsList(SportTeam $sportTeamsList): self
    {
        if ($this->sportTeamsList->removeElement($sportTeamsList)) {
            $sportTeamsList->removeAthleteFromList($this);
        }

        return $this;
    }
}
