<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Validator\Type\SubmitTypeValidatorExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' =>  'Mon adresse email'
            ])
            // ->add('roles')
            ->add('firstname', TextType::class,  [
                'disabled' => true,
                'label' =>  'Mon prénom'
            ])
            ->add('lastname', TextType::class,  [
                'disabled' => true,
                'label' =>  'Mon nom'
            ])
            ->add('oldPassword', PasswordType::class,  [
                'label' =>  'Mon mot de passe',
                'mapped'    =>  false,
                'attr' => [
                    'placeholder' =>  'Merci de confirmer votre mot de passe'
                ]
            ])
            ->add('newPassword', RepeatedType::class, 
            [
                'type'  => PasswordType::class,
                'mapped'    =>  false,
                'invalid_message'   => 'les mots de passe doivent être identiques',
                'label' =>  'Votre mot de passe',
                'required'  => true,
                'first_options'     =>  
                [
                    'label'    =>  'Votre mot de passe',
                    "attr"  =>  
                    [
                        'placeholder' => 'merci de saisir votre nouveau mot de passe'
                    ]
                ],
                'second_options'    =>  
                [
                    'label'    =>  'confirmez votre mot de passe',
                    "attr"  =>  
                    [
                        'placeholder' => 'merci de confirmer votre nouveau mot de passe'
                    ]
                ]             
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Changer le mot de passe'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
