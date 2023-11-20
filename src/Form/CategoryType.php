<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $picture = $options['picture'];
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom de la catégorie :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nouvelle catégorie',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne doit pas être vide',
                    ]),
                ],
            ])
            ->add('picture' ,FileType::class,[
                'label' => 'Bandeau de la catégorie :',
                'data_class' => null,
                'required' => false,
                'empty_data' => $picture,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryCollection::class,
            'picture' => '',
        ]);
    }
}
