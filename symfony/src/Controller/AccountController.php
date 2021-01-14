<?php

namespace App\Controller;

use App\Form\PersonalInfoFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
                'user' => $this->getUser()
            ]
        );
    }

    /**
     * @Route("/myAccount/personalInfo", name="personalInfo")
     */
    public function UpdatePersonalInfo(Request $request): Response
    {
        if (!$this->getUser()) {
            $this->addFlash(
                'warning',
                "Pour accéder à cette page, vous devez d'abord vous connecter."
            );
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(PersonalInfoFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();

                $user = $form->getData();

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Votre compte a été mis à jour avec succès');

                return $this->render(
                    'account/index.html.twig',
                    [
                        'user' => $this->getUser(),
                        'myAccount_list' => 'personalInfo',
                        'personalInfo' => $form->createView()
                    ]
                );
            }
            $this->addFlash('warning', "Une erreur est survenue lors de la mise à jour de votre profil");
            return $this->render(
                'account/index.html.twig',
                [
                    'user' => $this->getUser(),
                    'myAccount_list' => 'personalInfo',
                    'personalInfo' => $form->createView()
                ]
            );
        }
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
