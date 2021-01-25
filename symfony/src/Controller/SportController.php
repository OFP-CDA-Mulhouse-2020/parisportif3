<?php

namespace App\Controller;

use App\Entity\SportEvent;
use App\Entity\SportType;
use App\Form\BetTemplateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/sport", name="sport")
     */
    public function index(): Response
    {
        return $this->render(
            'sport/index.html.twig',
            [
                'SportTypeList' => $this->getSportTypeList()
            ]
        );
    }

    public function getSportTypeList(): array
    {
        return $this->getDoctrine()->getRepository(SportType::class)->findAll();
    }

    /**
     * @Route("/singleSport/{sportType}", name="SingleSport")
     */
    public function showSingleSport($sportType): Response
    {
        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $this->getSportTypeList(),
                'CompetitionList' => $this->getCompetitionList($sportType),
                'sportType' => $sportType
            ]
        );
    }

    public function getCompetitionList(string $sportName): array
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->findCompetitionList($this->getSportTypeFromString($sportName));
    }

    public function getSportTypeFromString(string $sportName)
    {
        /** @var array<int,SportType> $sportType */
        $sportType = $this->getDoctrine()
            ->getRepository(SportType::class)
            ->findBy(["name" => $sportName]);
        return $sportType[0];
    }

    /**
     * @Route("/singleCompetition/{sportType}/{competitionName}" , name="SingleCompetition")
     */
    public function showSingleCompetition($sportType, $competitionName): Response
    {
        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $this->getSportTypeList(),
                'sportType' => $sportType,
                'CompetitionList' => $this->getCompetitionList($sportType),
                'EventList' => $this->getEventListFromCompetition($competitionName, $sportType,)
            ]
        );
    }

    public function getEventListFromCompetition(string $competitionName, string $sportName): array
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->findEventListFromCompetition($competitionName, $this->getSportTypeFromString($sportName));
    }

    /**
     * @Route("/singleEvent/{id}", name="SingleEvent")
     */
    public function showSingleEvent($id): Response
    {
        $form = $this->createForm(BetTemplateFormType::class);


        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'Event' => $this->getEventFromID($id),
                'SportTypeList' => $this->getSportTypeList(),
                'BetList' => $form->createView()
            ]
        );
    }

    public function getEventFromID(int $id)
    {
        return $this->getDoctrine()
            ->getRepository(SportEvent::class)
            ->find($id);
    }
}
