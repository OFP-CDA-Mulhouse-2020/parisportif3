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
     * @var array<int>
     * @Assert\NotNull
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Type("int")
     * })
     */
    private array $choice = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoice(): ?array
    {
        return $this->choice;
    }

    public function setChoice(array $choice): self
    {
        $this->choice = $choice;

        return $this;
    }
}
