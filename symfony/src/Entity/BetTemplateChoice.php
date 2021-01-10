<?php

namespace App\Entity;

use App\Repository\BetTemplateChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BetTemplateChoiceRepository::class)
 * @UniqueEntity("id")
 * @TODO Ajouter l'unicité avec BetTemplate et updatedDescription
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
     * @ORM\Column(type="array")
     * @TODO Valider avec le validator
     */
    private array $updatedDescription = [];

    //TODO Ajouter la relation avec BetTemplate


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string>> */
    public function getUpdatedDescription(): ?array
    {
        return $this->updatedDescription;
    }

    /** @param array<string, array<string>> $updatedDescription */
    public function updateDescription(array $updatedDescription): self
    {
        $this->updatedDescription = $updatedDescription;

        return $this;
    }
}
