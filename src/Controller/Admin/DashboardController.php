<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Video;
use App\Entity\Profile;
use App\Entity\Activite;
use App\Entity\Discipline;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this ->render('admin/index.html.twig');
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Administrateur');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Acceuil');
        yield MenuItem::linkToRoute('Retour à l\'accueil', 'fa fa-home', 'app_home');
        yield MenuItem::section('Dashboard');
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-bars');
       
        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Profiles', 'fa-regular fa-id-badge', Profile::class);

        yield MenuItem::section('Activités & Disciplines');
        yield MenuItem::linkToCrud('Activités', 'fa-solid fa-puzzle-piece', Activite::class);
        yield MenuItem::linkToCrud('Disciplines', 'fa-solid fa-medal', Discipline::class);

        yield MenuItem::section('Photos & Videos');
        yield MenuItem::linkToCrud('Photos', 'fa-regular fa-image', Photo::class);
        yield MenuItem::linkToCrud('Videos', 'fa-solid fa-video', Video::class);
    }
}

