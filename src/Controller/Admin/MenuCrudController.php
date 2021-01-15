<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MenuCrudController extends AbstractCrudController
{
    public function __construct(MenuRepository $menuRepository) {
        $this->menuRepository = $menuRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('icon')->setRequired(false)->setHelp('Enter icon class i.e. fa-pencil, fa-tree'),
            ChoiceField::new('role')->setChoices([
                'Super Admin' => 'ROLE_ADMIN',
                'Author' => 'ROLE_AUTHOR'
            ]),
            ChoiceField::new('type')->setChoices([
                'Dashboard' => 'linkToDashboard', 
                'Crud' => 'linkToCrud',
                'Section' => 'section'
            ])->setRequired(false),
            ChoiceField::new('entity_path')->setChoices($this->menuRepository->findEntityList())->setRequired(false),
            BooleanField::new('status')->setRequired(false),
            DateTimeField::new('created')->hideOnForm(),
        ];
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityPermission('ROLE_ADMIN');
    }
}
