<?php

namespace App\Entity;

use App\Repository\BetTemplateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetTemplateRepository::class)
 * @UniqueEntity(
 *     fields={"id", "description"},
 *     errorPath="description"
 * )
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
     * @ORM\Column(type="array")
     * @var array<string, array<string, array<string>>>
     * @Assert\NotBlank
     * @Assert\NotNull
     *
     * @Assert\Collection(
     *     fields = {
     *         "BET_LIST" = @Assert\Required({
     *              @Assert\NotNull,
     *              @Assert\NotBlank,
     *              @Assert\Type("array")
     *         })
     *     }
     * )
     */
    private array $description = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string, array<string>>>|null */
    public function getDescription(): ?array
    {
        return $this->description;
    }

    /** @param array<string, array<string, array<string>>> $description */
    public function setDescription(array $description): self
    {
        $this->description = $description;

        return $this;
    }

    //TODO Ajouter la relation avec SportType

    //TODO Ajouter la relation avec BetTemplateChoice
}
