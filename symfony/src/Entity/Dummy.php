<?php

namespace App\Entity;

use App\Repository\DummyRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DummyRepository::class)
 */
class Dummy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $birthdate;

    /**
     * Dummy constructor.
     * @param string $name
     * @param string $password
     * @param DateTimeInterface $birthdate
     */
    public function __construct(string $name, string $password, DateTimeInterface $birthdate){
                $this->name = $name;
                $this->password = $password;
                $this->birthdate = $birthdate;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthdate(): ?DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public static function setFromString(string $name, string $password, DateTimeInterface $birthDate):self{
        return new self($name, $password,$birthDate);
    }
}
