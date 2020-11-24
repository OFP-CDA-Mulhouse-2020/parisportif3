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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $updateDescription;

    /**
     * @ORM\ManyToOne(targetEntity=Transaction::class, inversedBy="betTemplateChoice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdateDescription(): ?string
    {
        return $this->updateDescription;
    }

    public function setUpdateDescription(string $updateDescription): self
    {
        $this->updateDescription = $updateDescription;

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }
}
