<?php

namespace App\Entity;

use App\Repository\BetTemplateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=BetTemplateRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("sportType")
 */
final class BetTemplate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var array<string, array<string>>
     *
     * @ORM\Column(type="array")
     *
     * @Assert\NotBlank
     */
    private array $abstractBets = [];

    /**
     * @ORM\OneToOne(targetEntity=SportType::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid
     */
    private SportType $sportType;


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string>> */
    public function listAbstractBets(): array
    {
        return $this->abstractBets;
    }

    /** @param array<string, array<string>> $newAbstractBetsList */
    public function setAbstractBets(array $newAbstractBetsList): self
    {
        $this->abstractBets = $newAbstractBetsList;

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

    /** @Assert\Callback */
    public function validateAbstractBets(ExecutionContextInterface $context): void
    {
        //TODO Implémenter
    }
}
