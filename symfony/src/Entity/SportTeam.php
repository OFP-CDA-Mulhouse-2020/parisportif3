<?php

namespace App\Entity;

use App\Repository\SportTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var Collection<int, Athlete>
     *
     * @ORM\ManyToMany(targetEntity=Athlete::class)
     */
    private Collection $athletesList;


    public function __construct()
    {
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

    /** @Assert\Callback */
    public function validate(ExecutionContextInterface $context): void
    {
        $validator = $context->getValidator();

        foreach ($this->athletesList as $athlete) {
            if (!is_a($athlete, Athlete::class)) {
                $context->buildViolation("athletesList contain a non Athlete")
                    ->atPath("athletesList")
                    ->addViolation();
            } elseif ($validator->validate($athlete)->count()) {
                $context->buildViolation("athletesList contain a non valid Athlete")
                    ->atPath("athletesList")
                    ->addViolation();
            }
        }
    }
}
