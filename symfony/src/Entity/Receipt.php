<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReceiptRepository::class)
 */
final class Receipt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
