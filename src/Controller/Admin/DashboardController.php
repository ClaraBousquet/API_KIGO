<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Media;
use App\Entity\Messages;
use App\Entity\Post;
use App\Entity\Profil;
use App\Entity\Skills;
use App\Entity\TypeContact;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController 
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        $url = $this->adminUrlGenerator
            ->setController(PostCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
        

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle( 'KIGO ADMINISTRATOR' );
    }

    public function configureMenuItems(): iterable
    {
        // Section principale
       yield MenuItem::section('Gestion Projets');
       
       // Liste des sous-menus
       yield MenuItem::subMenu('Gestion des messages', 'fa fa-message')->setSubItems([
        MenuItem::linkToCrud('Ajouter un message', 'fa fa-plus', Messages::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des messages', 'fa fa-list', Messages::class),
       ]);
        
        yield MenuItem::subMenu('Gestion des contacts', 'fa fa-users')->setSubItems([
        MenuItem::linkToCrud('Ajouter un contact', 'fa fa-plus', Contact::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des contacts', 'fa fa-list', Contact::class),
       ]);

        yield MenuItem::subMenu('Gestion des types de contact', 'fa fa-users')->setSubItems([
        MenuItem::linkToCrud('Ajouter un type de contact', 'fa fa-plus', TypeContact::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des types de contact', 'fa fa-list', TypeContact::class),
       ]);

       yield MenuItem::subMenu('Gestion des médias', 'fa fa-link')->setSubItems([
        MenuItem::linkToCrud('Ajouter un média', 'fa fa-plus', Media::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des médias', 'fa fa-list', Media::class),
       ]);

       yield MenuItem::subMenu('Gestion des posts', 'fa fa-clipboard')->setSubItems([
        MenuItem::linkToCrud('Ajouter un post', 'fa fa-plus', Post::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des posts', 'fa fa-list', Post::class),
       ]);

        yield MenuItem::subMenu('Gestion des projets', 'fa fa-briefcase')->setSubItems([
        MenuItem::linkToCrud('Ajouter un projet', 'fa fa-plus', Post::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des projets', 'fa fa-list', Post::class),
       ]);

          yield MenuItem::subMenu('Gestion des compétences', 'fa fa-puzzle-piece')->setSubItems([
        MenuItem::linkToCrud('Ajouter une compétence', 'fa fa-plus', Skills::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des compétences', 'fa fa-list', Skills::class),
       ]);
        // Section User
       yield MenuItem::section('Gestion Utilisateurs');

         yield MenuItem::subMenu('Gestion des Utilisateurs', 'fa fa-user-circle-o')->setSubItems([
        MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
        MenuItem::linkToCrud('Liste des utilisateurs', 'fa fa-list', User::class),
       ]);

       
    }
}
