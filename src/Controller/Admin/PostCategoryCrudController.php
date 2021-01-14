<?php

namespace App\Controller\Admin;

use App\Entity\PostCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PostCategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('category_name'),
            TextEditorField::new('description'),
            AssociationField::new('parent'),
            BooleanField::new('status'),
            DateTimeField::new('created')->hideOnForm(),
            DateTimeField::new('updated')->hideOnForm(),
        ];
    }
   
}
