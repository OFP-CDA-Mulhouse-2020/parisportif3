<?php

namespace App\Entity;

use App\Repository\BetTemplateChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BetTemplateChoiceRepository::class)
 * @UniqueEntity("id")
 * @UniqueEntity({"betTemplate"})
 * @UniqueEntity({"updatedDescription"})
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
     *
     * @ORM\Column(type="array")
     */
    private array $betList = [];

    /**
     * @ORM\OneToOne(targetEntity=BetTemplate::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotNull()
     */
    private BetTemplate $betTemplate;


    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return array<string, array<string>> */
    public function listAvailableBets(): array
    {
        return $this->betList;
    }

    public function getBetTemplate(): BetTemplate
    {
        return $this->betTemplate;
    }

    public function setBetTemplate(BetTemplate $betTemplate): self
    {
        $this->betTemplate = $betTemplate;

        return $this;
    }

    public function updateDescription(SportEvent $sportEvent): self
    {
        $description = $this->getBetTemplate()->listAbstractBets();

        foreach ($description as $type => $bet) {
            $i = 0;
            $j = 0;
            foreach ($bet as $possibility) {
                if (preg_match("/%(?:.)*%/", $possibility)) {
                    $description[$type][$i] = $sportEvent->listSportTeams()[$j]->getTeamName();
                    $j++;
                }
                $i++;
            }
        }

        $this->betList = $description;
        return $this;
    }
}
