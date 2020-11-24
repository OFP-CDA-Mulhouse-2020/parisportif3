<?php

namespace App\Entity;

use App\Repository\BetChoicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetChoicesRepository::class)
 */
class BetChoices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $choice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoice(): ?int
    {
        return $this->choice;
    }

    public function setChoice(int $choice): self
    {
        $this->choice = $choice;

        return $this;
    }
}
