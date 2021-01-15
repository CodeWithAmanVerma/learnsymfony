<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
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
        $uploadPath = $this->getParameter('posts');
        
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('post_thumbnail')->setBasePath($uploadPath['uploads']['url_prefix'])->setUploadDir($uploadPath['uploads']['url_path'])->setRequired(false),
            TextField::new('post_title')->setRequired(false),
            TextEditorField::new('post_content')->setRequired(false),
            AssociationField::new('post_author')->hideOnForm()->setPermission('ROLE_ADMIN'),
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('post_content')
        ;
    }

    /* public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPaginatorPageSize(2);
    } */
   
}
