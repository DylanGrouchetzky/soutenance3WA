<?php

namespace App\Form;

use App\Entity\TomeCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom du tome',
                'attr' => ['placeholder' => 'Tome 1'],
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Enregistré',
                'attr' => ['class' => 'btn btn-blue']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TomeCollection::class,
        ]);
    }
}
