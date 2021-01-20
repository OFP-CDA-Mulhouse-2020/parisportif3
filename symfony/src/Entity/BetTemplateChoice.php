<?php

namespace App\Entity;

use App\Repository\BetTemplateChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=BetTemplateChoiceRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity({"betTemplate"})
 * @UniqueEntity({"updatedDescription"})
 */
final class BetTemplateChoice
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
    private array $betList = [];

    /**
     * @ORM\ManyToOne(targetEntity=BetTemplate::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Valid
     */
    private BetTemplate $betTemplate;


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string>> */
    public function listAvailableBets(): array
    {
        return $this->betList;
    }

    /** @param array<string, array<string>> $newAvailableBetList */
    public function setAvailableBets(array $newAvailableBetList): self
    {
        $this->betList = $newAvailableBetList;

        return $this;
    }

    public function getBetTemplate(): BetTemplate
    {
        return $this->betTemplate;
    }

    public function setBetTemplate(BetTemplate $betTemplate): self
    {
        $this->betTemplate = $betTemplate;

        return $this;
    }

    /** @Assert\Callback */
    public function validateBetList(ExecutionContextInterface $context): void
    {
        //TODO Implémenter le validator pour $this->betList
    }
}
