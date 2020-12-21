<?php

namespace App\Form;

use App\Entity\UserMerchant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MerchantRegister extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brandName', TextType::class, [
                'label' => 'Nom d\'entreprise'
            ])
            ->add('addessLine', TextType::class, [
                'label' => 'Adresse',
                'help' => 'Exemple: 7 rue des Fleurs',
            ])
            ->add('zipCode', NumberType::class, [
                'label' => 'Code postal',
                'help' => 'Exemple: 75000',
            ])
            ->add('description', TextareaType::class)      
            ->add('siretNumber', TextType::class, [
                'label' => 'Numéro de siret',
                'help' => '14 chiffres sans espace',
            ])     
            ->add('category', TextType::class, [
                'label' => 'Type d\'activité',
                'help' => 'Exemple: Boulangerie',
            ])     
            ->add('imageFile', VichImageType::class, [
                'label' => 'Logo de votre entreprise',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'imagine_pattern' => 'squared_thumbnail_small'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserMerchant::class,
        ]);
    }
}
