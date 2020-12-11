<?php

namespace App\Entity;

use App\Repository\BetTemplateChoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetTemplateChoiceRepository::class)
 */
class BetTemplateChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var array<string>
     * @ORM\Column(type="array")
     */
    private array $updatedDescription = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdatedDescription(): ?array
    {
        return $this->updatedDescription;
    }

    public function updateDescription(array $updatedDescription): self
    {
        $this->updatedDescription = $updatedDescription;

        return $this;
    }
}