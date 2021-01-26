<?php

namespace App\Controller\Admin;

use App\Entity\SportType;
use App\Entity\SportEvent;
use App\Entity\User;
use App\Entity\SportTeam;
use App\Entity\Athlete;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Bet', 'fas fa-list', SportType::class);
        yield MenuItem::linkToCrud('Sport Team', 'fas fa-list', SportTeam::class);
        yield MenuItem::linkToCrud('Sport Type', 'fas fa-list', SportType::class);
        yield MenuItem::linkToCrud('Sport Event', 'fas fa-list', SportEvent::class);
        yield MenuItem::linkToCrud('Athelete', 'fas fa-list', Athlete::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
    }
}
