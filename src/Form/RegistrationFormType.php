<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class , [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your first name',
                    ]),
                ]
            ])
            ->add('last_name', TextType::class , [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your last name',
                    ]),
                ]
            ])
            ->add('email', TextType::class , [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your email address',
                    ]),
                ]
            ])
            ->add('mobile', TextType::class , [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your mobile number',
                    ]),
                ]
            ])
            ->add('dob', DateType::class , [
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'empty_data' => null,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Enter your date of birth',
                    ]),
                ]
            ])
            ->add('gender', ChoiceType::class , [
                'choices' => [
                    'Select' => null,
                    'Female' => 'female',
                    'Male' => 'male',
                    'Others' => 'others'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Select any gender from list',
                    ]),
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => false,
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
