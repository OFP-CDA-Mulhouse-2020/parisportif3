<?php

namespace App\Entity;

use App\Repository\SportTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SportTypeRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity("name")
 */
final class SportType
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
     *     pattern= "/^(?:\p{L}{2,}|E)(?:[ '-]\p{L}+)*$/u"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\GreaterThan(0)
     */
    private int $nbrOfActiveAthlete;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): ?self
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrOfActiveAthlete(): ?int
    {
        return $this->nbrOfActiveAthlete;
    }

    public function setNbrOfActiveAthlete(int $nbrOfActiveAthlete): self
    {
        $this->nbrOfActiveAthlete = $nbrOfActiveAthlete;

        return $this;
    }
}
