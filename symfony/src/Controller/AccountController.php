<?php

namespace App\Controller;

use App\Form\PersonalInfoFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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

    private function handleForm(Request $request, array $flashMessage): FormInterface
    {
        $form = $this->createForm(PersonalInfoFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($form->getData());
                $entityManager->flush();

                $this->addFlash($flashMessage['success']['type'], $flashMessage['success']['message']);
            } else {
                $this->addFlash($flashMessage['fail']['type'], $flashMessage['fail']['message']);
            }
        }
        return $form;
    }

    /**
     * @Route("/myAccount/personalInfo", name="personalInfo")
     */
    public function UpdatePersonalInfo(Request $request): Response
    {
        if ($this->verifyIfUserIsConnected()) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->handleForm(
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
