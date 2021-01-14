<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('post_title')->setRequired(false),
            TextEditorField::new('post_content')->setRequired(false),
            AssociationField::new('post_author')->hideOnForm(),
            AssociationField::new('post_category'),
            ChoiceField::new('post_type')->setChoices([
                'Post' => 'post', 
                'Page' => 'page'
            ])->setRequired(false),
            TextField::new('post_slug')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('created')->hideOnForm(),
            DateTimeField::new('updated')->hideOnForm(),
            ChoiceField::new('post_status')->setChoices([
                'Draft' => 'draft', 
                'Pending' => 'pending', 
                'Active' => 'active', 
                'Inactive' => 'inactive'
            ])->setRequired(false),
        ];
    }
   
}
