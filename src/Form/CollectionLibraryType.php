<?php

namespace App\Form;

use App\Entity\GenreCollection;
use App\Entity\CollectionLibrary;
use Symfony\Component\Form\AbstractType;
use App\Repository\GenreCollectionRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CollectionLibraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $category_id = $options['category_id'];
        $picture = $options['picture'];
        $bgPicture = $options['bgPicture'];
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom de la collection :',
                'required' => true,
                'attr' => ['placeholder' => 'Nouvelle collection'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne doit pas être vide',
                    ]),
                ],
            ])
            ->add('status', ChoiceType::class,[
                'label' => 'Etat de la collection :',
                'choices' => [
                    'En cours' => 'progress',
                    'Compléter' => 'finish',
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description de la collection :',
                'attr' => ['placeholder' => 'Metter la description de la collection','rows' => 12],
            ])
            ->add('genreCollection', EntityType::class, [
                'label' => 'Le genre de la collection :',
                'class' => GenreCollection::class,
                'choice_label' => 'name',
                'multiple' => true,
                'query_builder' => function (GenreCollectionRepository $er) use ($category_id){
                    return $er->createQueryBuilder('g')
                        ->join('g.categoryCollection', 'c')
                        ->where('c.id = :category_id')
                        ->setParameter('category_id', $category_id);
                }
            ])
            ->add('picture' ,FileType::class,[
                'label' => 'Image de présentation de la collection :',
                'data_class' => null,
                'required' => false,
                'empty_data' => $picture,
            ])
            ->add('bgPicture' ,FileType::class,[
                'label' => 'Bandeau de présentation de la collection :',
                'data_class' => null,
                'required' => false,
                'empty_data' => $bgPicture,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CollectionLibrary::class,
            'category_id' => null,
            'picture' => '',
            'bgPicture' => '',
        ]);
    }
}
