<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label' =>  'Quel nom souhaitez vous donner à votre adresse?',
                'attr'  =>  [
                    'placeholder'   =>  'Le nom de votre adresse'
                ]
            ])
            ->add('firstname',TextType::class, [
                'label' =>  'Votre prénom',
                'attr'  =>  [
                    'placeholder'   =>  'Prénom'
                ]
            ])
            ->add('lastname',TextType::class, [
                'label' =>  'Votre nom',
                'attr'  =>  [
                    'placeholder'   =>  'Nom'
                ]
            ])
            ->add('Company',TextType::class, [
                'label' =>  'Quel est le nom de votre entreprise (facultatif)?',
                'attr'  =>  [
                    'placeholder'   =>  'Entreprise'
                ]
            ])
            ->add('adresse',TextType::class, [
                'label' =>  'Quelle est votre adresse?',
                'attr'  =>  [
                    'placeholder'   =>  '8 rue des lilas'
                ]
            ])
            ->add('postal',TextType::class, [
                'label' =>  'Quel est votre code postal',
                'attr'  =>  [
                    'placeholder'   =>  '75010'
                ]
            ])
            ->add('City',TextType::class, [
                'label' =>  'Quelle est votre ville?',
                'attr'  =>  [
                    'placeholder'   =>  'Paris'
                ]
            ])
            ->add('Land',Countrytype::class, [
                'label' =>  'Quel est votre pays?',
                'attr'  =>  [
                    'placeholder'   =>  'Pays'
                ]
            ])
            ->add('Phone',TelType::class, [
                'label' =>  'Quel est votre numéro de téléphone?',
                'attr'  =>  [
                    'placeholder'   =>  'Numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' =>  'Valider mon adresse',
                'attr'  =>  [
                    'class'   =>  'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
