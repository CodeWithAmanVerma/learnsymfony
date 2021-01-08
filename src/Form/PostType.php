<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post_title', null, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control' 
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Enter a post title or name. e.g Representation of your work',
                    ]),
                    new Assert\Length([
                        'max' => 4096
                    ]),
                ],
            ])
            ->add('post_content',null, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control' 
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Enter a description of your post or article.',
                    ]),
                    new Assert\Length([
                        'max' => 4096
                    ]),
                ],
            ])
            ->add('create', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary ' 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
