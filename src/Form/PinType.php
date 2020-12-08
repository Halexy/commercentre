<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', NULL, [
                'label' => 'Titre'
            ])
            ->add('description')      
            ->add('price', NULL, [
                'label' => 'Prix (€)'
            ])     
            ->add('imageFile', VichImageType::class, [
            'label' => 'Image (Fichier JPG ou PNG)',
            'required' => false,
            'allow_delete' => true,
            'delete_label' => 'Supprimer ?',
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
            'data_class' => Pin::class,
        ]);
    }
}
