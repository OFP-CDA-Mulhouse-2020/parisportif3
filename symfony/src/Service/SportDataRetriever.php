<?php


namespace App\Service;


use App\Entity\BetTemplate;
use App\Entity\BetTemplateChoice;
use App\Entity\SportEvent;
use App\Entity\SportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SportDataRetriever extends AbstractController
{
    public function getSportTypeList(): array
    {
        return $this->getDoctrine()->getRepository(SportType::class)->findAll();
    }

    public function getImminentEvent(): array
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->findAll();
    }

    public function getCompetitionList(string $sportName): array
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->findCompetitionList($this->getSportTypeFromString($sportName));
    }

    public function getSportTypeFromString(string $sportName): SportType
    {
        /** @var array<int,SportType> $sportType */
        $sportType = $this->getDoctrine()
            ->getRepository(SportType::class)
            ->findBy(["name" => $sportName]);
        return $sportType[0];
    }

    public function getEventListFromCompetition(string $competitionName, string $sportName): array
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->findEventListFromCompetition($competitionName, $this->getSportTypeFromString($sportName));
    }

    public function getEventFromID(int $id): SportEvent
    {
        /** @var SportEvent $sportEvent */
        $sportEvent = $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->find($id);
        return $sportEvent;
    }

    public function getBetListFromEvent(SportEvent $sportEvent): BetTemplateChoice
    {
        /** @var BetTemplate $betTemplateList */
        $betTemplateList = $this->getDoctrine()
            ->getRepository(BetTemplate::class)
            ->findBy(["sportType" => $sportEvent->getSportType()]);

        $betList = new BetTemplateChoice();
        $betList->setBetTemplate($betTemplateList[0]);

        return $betList->updateDescription($sportEvent);
    }
}