<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use App\Entity\CollectionLibrary;
use App\Entity\GenreCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameCollection',TextType::class,[
                'label' => "Nom :",
                'attr' => ['placeholder' => "Nom recherché",'class'=>"w-15 p-05 mt-1"],
                'required' => false,
                
            ])
            ->add('genreCollection',EntityType::class,[
                'label' => "Genre :",
                'class' => GenreCollection::class,
                'choice_label' => 'name',
                'attr' => ['class'=>"w-15 p-05 mt-1"],
                'placeholder' => 'Sélectionnez un genre',
                'required' => false,
            ])
            ->add('category',EntityType::class,[
                'label' => "Catégorie :",
                'class' => CategoryCollection::class,
                'choice_label' => 'name',
                'attr' => ['class'=>"w-15 p-05 mt-1"],
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
