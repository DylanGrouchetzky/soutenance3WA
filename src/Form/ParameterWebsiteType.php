<?php

namespace App\Form;

use App\Entity\ParameterWebsite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ParameterWebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $imgHeroSectionHome = $options['imgHeroSectionHome'];
        $logoWebsite = $options['logoWebsite'];
        $builder
            ->add('nameWebsite',TextType::class,[
                'label' => 'Nom du site :'
            ])
            ->add('imgHeroSectionHome',FileType::class,[
                'label' => 'Bandeau de la page principal :',
                'data_class' => null,
                'required' => false,
                'empty_data' => $imgHeroSectionHome,
            ])
            ->add('logoWebsite',FileType::class,[
                'label' => 'Logo du site :',
                'data_class' => null,
                'required' => false,
                'empty_data' => $logoWebsite,
            ])
            ->add('linkFacebook',TextType::class,[
                'label' => 'Lien pour facebook :'
            ])
            ->add('linkInstagram',TextType::class,[
                'label' => 'Lien pour instagram :'
            ])
            ->add('emailContact',TextType::class,[
                'label' => 'Email de contact :'
            ])
            ->add('textDetailWebsite',TextareaType::class,[
                'label' => 'Texte de description du site à la page d\'accueil :',
                'attr' => ['rows' => 12],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParameterWebsite::class,
            'imgHeroSectionHome' => '',
            'logoWebsite' => '',
        ]);
    }
}
