<?php

namespace App\Controller\Admin;
use App\Repository\MenuRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{

    public function __construct(MenuRepository $menuRepository) {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig',[
            'page_title' => 'Dashboard'
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Auth');
    }

    public function configureMenuItems(): iterable
    {
        $menuItems = [];
        $menuData = $this->menuRepository->findAll();
        foreach ($menuData as $menu) {
            if($menu->getType() == 'section'){
                $menuItems[] = MenuItem::{$menu->getType()}($menu->getName());
            }else if($menu->getType() == 'linktoDashboard'){
                $menuItems[] = MenuItem::{$menu->getType()}($menu->getName(), $menu->getIcon())->setPermission($menu->getRole());
            }else if($menu->getType() == 'linkToCrud'){
                $entity = $menu->getEntityPath();
                $entityObject = new $entity();
                $menuItems[] = MenuItem::{$menu->getType()}($menu->getName(), $menu->getIcon(), get_class($entityObject))->setPermission($menu->getRole());
            }
        }
        return $menuItems;
    }
}
