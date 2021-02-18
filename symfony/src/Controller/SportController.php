<?php

namespace App\Controller;

use App\Service\FormHandler;
use App\Service\SportDataRetriever;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/sport", name="sport")
     */
    public function index(SportDataRetriever $sportDataRetriever): Response
    {
        return $this->render(
            'sport/index.html.twig',
            [
                'SportTypeList' => $sportDataRetriever->getSportTypeList()
            ]
        );
    }

    /**
     * @Route("/singleSport/{sportType}", name="SingleSport")
     */
    public function showSingleSport($sportType, SportDataRetriever $sportDataRetriever): Response
    {
        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $sportDataRetriever->getSportTypeList(),
                'CompetitionList' => $sportDataRetriever->getCompetitionList($sportType),
                'sportType' => $sportType
            ]
        );
    }

    /**
     * @Route("/singleCompetition/{sportType}/{competitionName}" , name="SingleCompetition")
     */
    public function showSingleCompetition(
        $sportType,
        $competitionName,
        SportDataRetriever $sportDataRetriever
    ): Response {
        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $sportDataRetriever->getSportTypeList(),
                'sportType' => $sportType,
                'CompetitionList' => $sportDataRetriever->getCompetitionList($sportType),
                'EventList' => $sportDataRetriever->getEventListFromCompetition($competitionName, $sportType)
            ]
        );
    }

    /**
     * @Route("/singleEvent/{id}", name="SingleEvent")
     */
    public function showSingleEvent(
        $id,
        SportDataRetriever $sportDataRetriever,
        FormHandler $formHandler,
        Request $request,
        UserService $service
    ): Response {
        $event = $sportDataRetriever->getEventFromID($id);
        $form = $formHandler->handleBetListForm($request, $sportDataRetriever, $event, $service);


        return $this->render(
            'sport/index.html.twig',
            [
                'user' => $this->getUser(),
                'Event' => $sportDataRetriever->getEventFromID($id),
                'SportTypeList' => $sportDataRetriever->getSportTypeList(),
                'BetList' => $form->createView()
            ]
        );
    }

}
