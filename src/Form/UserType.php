<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Indiquez votre email'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices'=> [
                    'Admin'=> 'ROLE_ADMIN',
                    'User'=> 'ROLE-USER'
                ],
                'attr'=>[
                    'class' => 'form-control'  
                ],
                'expanded'=> true,
                'multiple'=> true
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                    'class' => 'password field form-control',
                    'placholder' => 'Indiquez votre password'
                    ]
                ],
                'first_options' => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'password field form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'class' => 'password field form-control'
                    ]
                 ],
                 'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Indiquez votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Indiquez votre prénom'
                ]
            ])
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'RH' => 1,
                    'Informatique' => 2,
                    'Comptabilité' => 3,
                    'Direction' => 4,
                ],
                'choice_attr' => [
                    'RH' => ['data-color' => 'Red'],
                    'Informatique' => ['data-color' => 'Yellow'],
                    'Comptabilité' => ['data-color' => 'Green'],
                    'Direction' => ['data-color' => 'Blue'],
                ],
                'attr'=>[
                    'class' => 'form-control'  
                ],
                'expanded'=> true,
                'multiple'=> true
            ])
            ->add('contrat', ChoiceType::class, [
                'choices' => [
                    'CDI' => 1,
                    'CDD' => 2,
                    'Interim' => 3,
                    
                ],
                'choice_attr' => [
                    'CDI' => ['data-color' => 'Red'],
                    'CDD' => ['data-color' => 'Yellow'],
                    'Interim' => ['data-color' => 'Green'],
                    
                ],
                'attr'=>[
                    'class' => 'form-control'  
                ],
                'expanded'=> true,
                'multiple'=> true
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image de l\'employé',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Fichier invalide',
                        'maxSizeMessage'   => 'Fichier trop lourd'
                    ])
                ],
            ])
            ->add('sortie', BirthdayType::class)   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
