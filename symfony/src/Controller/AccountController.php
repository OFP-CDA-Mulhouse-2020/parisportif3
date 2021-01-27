<?php

namespace App\Controller;

use App\Service\FormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AccountController extends AbstractController
{
    /**
     * @Route("/myAccount", name="account")
     */
    public function index(): Response
    {
        if ($this->verifyIfUserIsConnected()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'account/index.html.twig',
            [
                'user' => $this->getUser()
            ]
        );
    }

    private function verifyIfUserIsConnected(): bool
    {
        if (!$this->getUser()) {
            $this->addFlash(
                'warning',
                "Pour accéder à cette page, vous devez d'abord vous connecter."
            );
            return true;
        }
        return false;
    }

    /**
     * @Route("/myAccount/personalInfo", name="personalInfo")
     */
    public function updatePersonalInfo(Request $request, FormHandler $formHandler): Response
    {
        if ($this->verifyIfUserIsConnected()) {
            return $this->redirectToRoute('app_login');
        }

        $form = $formHandler->handlePersonalInfoUpdateForm(
            $request,
            [
                'success' => [
                    'type' => 'success',
                    'message' => 'Vos informations on bien été mis à jour'
                ],
                'fail' => [
                    'type' => 'warning',
                    'message' => 'Une erreur est survenue pendant la mise à jour de votre profil'
                ]
            ]
        );

        return $this->render(
            'account/index.html.twig',
            [
                'user' => $this->getUser(),
                'myAccount_list' => 'personalInfo',
                'personalInfo' => $form->createView()
            ]
        );
    }
}
