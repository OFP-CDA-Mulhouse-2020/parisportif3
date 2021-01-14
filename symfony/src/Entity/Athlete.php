<?php

namespace App\Entity;

use App\Repository\AthleteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;

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
     *
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern = "/^\p{L}{2,}(?:[' -]\p{L}+)*$/u"
     * )
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern = "/^\p{L}{2,}(?:['-]\p{L}+)*$/u"
     * )
     */
    private string $firstName;

    /**
     * @var Collection<int, SportTeam>
     *
     * @ORM\ManyToMany(targetEntity=SportTeam::class, mappedBy="athleteList")
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

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /** @return Collection<int, SportTeam> */
    public function listSportTeams(): Collection
    {
        return $this->sportTeamsList;
    }

    public function joinTeam(SportTeam $newTeam): self
    {
        if (!$this->sportTeamsList->contains($newTeam)) {
            $this->sportTeamsList[] = $newTeam;
            $newTeam->addAthlete($this);
        }

        return $this;
    }

    public function leaveTeam(SportTeam $oldTeam): self
    {
        if ($this->sportTeamsList->removeElement($oldTeam)) {
            $oldTeam->removeAthlete($this);
        }

        return $this;
    }

    /** @Assert\Callback */
    public function validateSportTeamsList(ExecutionContextInterface $context): void
    {
        $validator = Validation::createValidator();

        foreach ($this->sportTeamsList as $sportTeam) {
            if (!assert($sportTeam instanceof SportTeam)) {
                $context->buildViolation("sportTeamsList contain a non SportTeam object")
                    ->atPath("sportTeamsList")
                    ->addViolation();
                break;
            }

            $violations = $validator->validate($sportTeam);

            $violationsCount = $violations->count();
            if ($violationsCount > 0) {
                $context->buildViolation("sportTeamsList contain non valid SportTeam object(s)")
                    ->atPath("sportTeamsList")
                    ->addViolation();
                break;
            }
        }
    }
}
