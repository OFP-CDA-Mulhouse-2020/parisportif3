<?php

namespace App\Entity;

use App\Repository\BetChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=BetChoiceRepository::class)
 * @UniqueEntity("id")
 */
final class BetChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="array")
     *
     * @var array<string, int>
     */
    private array $choice = [];

    /**
     * @ORM\OneToOne(targetEntity=BetTemplateChoice::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull()
     */
    private BetTemplateChoice $betTemplateChoice;


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, int> */
    public function getChoice(): ?array
    {
        return $this->choice;
    }

    /** @param array<string, int> $choice */
    public function setChoice(array $choice): self
    {
        $this->choice = $choice;

        return $this;
    }

    /**
     * @Assert\Callback()
     * @TODO Ajouter le test avec BetTemplateChoice
     */
    public function validateChoice(ExecutionContextInterface $context): void
    {
        foreach ($this->choice as $bet => $choice) {
            if (!is_string($bet)) {
                $context->buildViolation("Bet is not a string")
                    ->atPath("choice")
                    ->addViolation();
            }
            if (!is_int($choice)) {
                $context->buildViolation("Choice is not a int")
                    ->atPath("choice")
                    ->addViolation();
            }
        }
    }

    public function getBetTemplateChoice(): BetTemplateChoice
    {
        return $this->betTemplateChoice;
    }

    public function setBetTemplateChoice(BetTemplateChoice $betTemplateChoice): self
    {
        $this->betTemplateChoice = $betTemplateChoice;

        return $this;
    }
}
