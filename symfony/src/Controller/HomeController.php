<?php

namespace App\Controller;

use App\Service\SportDataRetriever;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SportDataRetriever $sportDataRetriever): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'user' => $this->getUser(),
                'SportTypeList' => $sportDataRetriever->getSportTypeList(),
                'EventList' => $sportDataRetriever->getImminentEvent()
            ]
        );
    }


}
