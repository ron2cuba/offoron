<?php

namespace App\Form;

use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom du style :',
                'attr'=> [
                    'placeholder'=>'Entrez le nom du style'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description',
                'attr'=> [
                    'placeholder'=>'Saisir une description',
                    'rows'=>4,
                    'cols'=>33
                ]
            ])
            ->add('mainPicture', UrlType::class, [
                'label'=>'Image | Design | Photo :',
                'attr'=>[
                    'placeholder'=>'choisir'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Style::class,
        ]);
    }
}
