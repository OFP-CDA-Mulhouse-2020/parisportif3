<?php

namespace App\Entity;

use App\Repository\BetTemplateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetTemplateRepository::class)
 * @UniqueEntity("id")
 * @TODO Rajouter les l'unicité après avoir rajouter les relations
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
     * @var array<string, array<string>>
     * @Assert\NotBlank
     *
     * @TODO Tester avec le validateur
     */
    private array $availableBetsList = [];

    //TODO Ajouter la relation avec SportType

    //TODO Ajouter la relation avec BetTemplateChoice


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string>> */
    public function getAvailableBetsList(): array
    {
        return $this->availableBetsList;
    }

    /** @param array<string, array<string>> $availableBetsList */
    public function setAvailableBetsList(array $availableBetsList): self
    {
        $this->availableBetsList = $availableBetsList;

        return $this;
    }
}
