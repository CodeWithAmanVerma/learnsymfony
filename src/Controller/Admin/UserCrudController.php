<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityPermission('ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email')->setRequired(false),
            TextField::new('first_name')->setRequired(false),
            TextField::new('last_name')->setRequired(false),
            ChoiceField::new('gender')->setChoices([
                'Female' => 'female',
                'Male' => 'male',
                'Other' => 'other'
            ])->setRequired(false),
            ArrayField::new('roles'),
            TelephoneField::new('mobile')->setRequired(false),
            DateTimeField::new('dob')->setLabel('Date of Birth')->setRequired(false),
            ChoiceField::new('status')->setChoices([
                'Active' => 'active',
                'Inactive' => 'inactive'
            ])->setRequired(false),
        ];
    }
}
