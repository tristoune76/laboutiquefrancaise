<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Carrier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('adresses', EntityType::class, [
                'label'     =>  false,
                'required'  =>  true,
                'class'     =>  Adresse::class,
                'multiple'  =>  false,
                'expanded'  =>  true,
                'choices'   =>  $user->getAdresses()
            ])
            ->add('transporteurs', EntityType::class, [
                'label'     =>  'Choisissez votre Transporteur',
                'required'  =>  true,
                'class'     =>  Carrier::class,
                'multiple'  =>  false,
                'expanded'  =>  true,
            ])
            ->add('submit', SubmitType::class, [
                'label' =>  'Valider ma commande',
                'attr'  =>  [
                    'class'   =>  'btn-block btn-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user'  =>  array([])
        ]);
    }
}
