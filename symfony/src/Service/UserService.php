<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController
{
    public function verifyIfUserIsConnected(): bool
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
}