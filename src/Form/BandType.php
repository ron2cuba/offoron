<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label'=>'Nom du groupe | Artiste :',
            'attr'=>[
                'placeholder'=>'Entrez le nom'
            ]
        ])
                ->add('mainPicture', UrlType::class, [
                    'label'=>'Image | Design | Photo :',
                    'attr'=>[
                        'placeholder'=>'Choisir'
                        ]
                ])
                ->add('description', TextareaType::class, [
                    'label'=>'Description :',
                    'attr'=>[
                        'placeholder'=>'Saisir une description représentant l\'artiste ou le groupe',
                        'rows'=>4,
                        'cols'=>33
                    ]
                ])
                ->add('style',  EntityType::class, [
                    'label'=>'Style',
                    'placeholder'=>'-- Style --',
                    'class'=>Style::class,
                    'choice_label'=>'name'
                ])
                ->add('isFeatured', ChoiceType::class, [
                    'choices'  => [
                        'Non' => false,
                        'Oui' => true,
                    ],
                    'label'=>'Groupe à la une :',
                    'placeholder'=>'-- Choisir la mise en avant --'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
