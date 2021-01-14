<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Auth');
    }

    public function configureMenuItems(): iterable
    {
        
        return [
            MenuItem::section('Main'),
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Categories', 'fa fa-sitemap', PostCategory::class),
            MenuItem::linkToCrud('Posts', 'fa fa-file-text', Post::class),
        ];
    }
}
