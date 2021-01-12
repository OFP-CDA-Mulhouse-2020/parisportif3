<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/myAccount", name="account")
     */
    public function index(): Response
    {
        if (!$this->getUser()) {
            $this->addFlash(
                'warning',
                "Pour accéder à cette page, vous devez d'abord vous connecter."
            );
            return $this->redirectToRoute('app_login');
        }
        return $this->render(
            'account/index.html.twig',
            [
                'controller_name' => 'AccountController',
                'user' => $this->getUser()
            ]
        );
    }
}
