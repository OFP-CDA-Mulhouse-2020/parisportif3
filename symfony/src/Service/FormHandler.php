<?php


namespace App\Service;

use App\Entity\BetChoice;
use App\Entity\SportEvent;
use App\Entity\User;
use App\Form\BetListType;
use App\Form\BetTemplateFormType;
use App\Form\PersonalInfoFormType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormHandler extends AbstractController
{
    private object $entityManager;


    /**
     * @throws TransportExceptionInterface
     */
    public function handleRegistrationForm(
        Request $request,
        User $user,
        UserPasswordEncoderInterface $passwordEncoder,
        MailService $mailService
    ) {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->persistData($user);
            $mailService->sendRegistrationEmailToUser($user);

            return true;
        }
        return $form;
    }

    public function persistData(object $data): void
    {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function handlePersonalInfoUpdateForm(Request $request, array $flashMessage): FormInterface
    {
        $form = $this->createForm(PersonalInfoFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->persistData($form->getData());
                $this->addFlash($flashMessage['success']['type'], $flashMessage['success']['message']);
            } else {
                $this->addFlash($flashMessage['fail']['type'], $flashMessage['fail']['message']);
            }
        }
        return $form;
    }

    public function handleBetListForm(
        Request $request,
        SportDataRetriever $sportDataRetriever,
        SportEvent $sportEvent,
        UserService $service
    ): FormInterface {
        $clientBet = [];

        $form = $this->createForm(
            BetListType::class,
            null,
            [
                "data" => [
                    "sportData" => $sportDataRetriever,
                    "sportEvent" => $sportEvent
                ]
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && !$service->verifyIfUserIsConnected()) {
            foreach ($form->getData() as $key => $values) {
                if ($values === true) {
                    $clientBet += [$key => $values];
                }
            }
            $userBet = new BetChoice();
            $userBet->setChoice($clientBet);
        }
        return $form;
    }
}