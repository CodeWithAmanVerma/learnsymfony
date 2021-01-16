<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostCategoryRepository;
use App\Repository\PostRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostCrudController extends AbstractCrudController
{
    public function __construct(
        AdminUrlGenerator $adminUrlGenerator, 
        PostCategoryRepository $postCategoryRepository, 
        PostRepository $postRepository, 
        SluggerInterface $slugger,
        LoggerInterface $logger
    ) {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->postCategoryRepository = $postCategoryRepository;
        $this->postRepository = $postRepository;
        $this->slugger = $slugger;
        $this->logger = $logger;
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        $uploadPath = $this->getParameter('posts');

        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('post_thumbnail')->setLabel('Image')->setBasePath($uploadPath['uploads']['url_prefix'])->setUploadDir($uploadPath['uploads']['url_path'])->setRequired(false),
            TextField::new('post_title')->setRequired(false),
            TextEditorField::new('post_content')->setRequired(false),
            AssociationField::new('post_author')->setPermission('ROLE_ADMIN'),
            AssociationField::new('post_category')->setLabel('Category'),
            ChoiceField::new('post_type')->setChoices([
                'Post' => 'post', 
                'Page' => 'page'
            ])->setRequired(false)->hideOnIndex(),
            TextField::new('post_slug')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('created')->hideOnForm()->hideOnIndex(),
            DateTimeField::new('updated')->setLabel('Last Modified')->hideOnForm(),
            ChoiceField::new('post_status')->setLabel('Status')->setChoices([
                'Draft' => 'draft', 
                'Pending' => 'pending', 
                'Active' => 'active', 
                'Inactive' => 'inactive'
            ])->setRequired(false),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $importPostButton = Action::new('importPost', 'Import')->setCssClass('btn btn-default')->createAsGlobalAction()->linkToCrudAction('importPost');
        $exportPostButton = Action::new('exportPost', 'Export')->setCssClass('btn btn-default')->createAsGlobalAction()->linkToCrudAction('exportPost');
        
        return $actions
            ->add(Crud::PAGE_INDEX, $exportPostButton)
            ->add(Crud::PAGE_INDEX, $importPostButton)
        ;
    }
    
    public function importPost(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);        
        $form->handleRequest($request);

        $importedFile = $form->get('import_file')->getData();
        if ($form->isSubmitted() && $importedFile) {
            $jsonData = file_get_contents($importedFile);
            $entityManager = $this->getDoctrine()->getManager();
            
            try{
                $postData = json_decode($jsonData);
                
                foreach ($postData as $postItem) {
                    $newPost = new Post();
                    $category = $this->postCategoryRepository->find($postItem->post_category_id);
                    $newPost->setPostTitle($postItem->post_title);
                    $newPost->setPostSlug($this->slugger->slug($postItem->post_title));
                    $newPost->setPostContent($postItem->post_content);
                    $newPost->setPostType((!empty($postItem->post_type))?$postItem->post_type:'post');
                    if(!empty($category)){
                        $newPost->setPostCategory($category);
                    }
                    $newPost->setCreated(new \DateTime());
                    $newPost->setUpdated(new \DateTime());
                    $newPost->setPostAuthor($this->getUser());
                    $newPost->setPostStatus('draft');

                    $entityManager->persist($newPost);
                    $entityManager->flush();
                }

                $this->addFlash('success', 'Post(s) data has been imported successfully');
                $this->logger->info('Data imported', $postData);
            } catch (\Exception $e){
                $this->addFlash('error', 'Unable to import data correctly.');
                $this->logger->error('Unable to import data correctly.');
            }
        }else{
            $this->logger->error('File was not uploaded');
        }

        return $this->render('admin/post/import.html.twig', [
            'page_title' => 'Import Post',
            'back_link' => $this->adminUrlGenerator->setController(PostCrudController::class)->setAction(Action::INDEX)->generateUrl(),
            'form' => $form->createView()
        ]);
    }

    public function exportPost()
    {
        try {
            $posts = $this->postRepository->findDownloadableData();
            $filename = sprintf("%s_%s.json", 'EXPORT_FILE_POST',microtime(true));
            if(empty($posts)){
                $this->addFlash('error', "There are no post(s) available in the list.");
            }else{
                $response = new Response(json_encode($posts)); 
                $disposition = HeaderUtils::makeDisposition(
                    HeaderUtils::DISPOSITION_ATTACHMENT,
                    $filename
                );
                $response->headers->set('Content-Disposition', $disposition);

                return $response;
            }
        } catch (\Exception $e) {
            $this->addFlash('error', "Something wrong!! Try to find the perfect exception.");
        }
        
        return $this->redirect($this->adminUrlGenerator->setController(PostCrudController::class)->setAction(Action::INDEX)->generateUrl());
    }
}
