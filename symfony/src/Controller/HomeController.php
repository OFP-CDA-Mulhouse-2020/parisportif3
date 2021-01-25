<?php

namespace App\Controller;

use App\Entity\SportEvent;
use App\Entity\SportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $this->getSportTypeList(),
                'EventList' => $this->getImminentEvent()
            ]
        );
    }

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
}
