<?php

namespace App\Entity;

use App\Repository\BetChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetChoiceRepository::class)
 */
final class BetChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="array")
     *
     * @TODO Corriger les assertions pour coller à l'UML
     *
     * @var array<int>
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\GreaterThan(0),
     *     @Assert\NotNull,
     *     @Assert\NotBlank,
     *     @Assert\Type("int")
     * })
     */
    private array $choice = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @TODO Corriger pour coller à l'UML
     * @return array<int>
     */
    public function getChoice(): ?array
    {
        return $this->choice;
    }

    /**
     * @TODO Corriger pour coller à l'UML
     * @param array<int> $choice
     */
    public function setChoice(array $choice): self
    {
        $this->choice = $choice;

        return $this;
    }
}
