<?php

namespace App\Form;

use App\Entity\UserMerchant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MerchantRegisterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $array = array(
            "Agroalimentaire", 
            "Chimie, plastique, santé", 
            "Commerce de détail",
            "Construction, bâtiment, bois",
            "Énergie, environnement",
            "Formation - administrations",
            "Habitation",
            "Horlogerie, bijouterie",
            "Informatique, internet",
            "Loisirs, tourisme, culture",
            "Matériel électrique, électronique, optique",
            "Métallurgie, mécanique",
            "Papier, impression",
            "Restauration rapide",            
            "Services aux entreprises",
            "Textile, habillement",
            "Transports et logistique",
        );
        
        $builder
            ->add('brandName', TextType::class, [
                'label' => 'Nom d\'entreprise'
            ])
            ->add('addessLine', TextType::class, [
                'label' => 'Adresse',
                'help' => 'Exemple: 7 rue des Fleurs',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'help' => 'Exemple: 87000',
                'attr' => [
                    'class' => 'zipCode',
                ]
            ])
            ->add('city', ChoiceType::class, [
                'label' => 'Ville',
                'help' => 'Entrez un code postal pour avoir les villes',
                'attr' => [
                    'class' => 'city',
                ],
                
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'help' => 'Ne pas mettre le 0',
                'attr' => [
                    'placeholder' => '612345678',
                ]
                
            ])  
            ->add('description', TextareaType::class)      
            ->add('additionalInformation', TextareaType::class, [
                'label' => 'Informations supplémentaires',
                'required' => false,
            ])
            ->add('siretNumber', TextType::class, [
                'label' => 'Numéro de siret',
                'help' => '14 chiffres sans espace',
            ])     
            ->add('category', ChoiceType::class, array(
                'label' => 'Secteur d\'activité',
                'choices'  => array_combine($array, $array),
            ))
            ->add('imageFile', VichImageType::class, [
                'label' => 'Logo de votre entreprise',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'imagine_pattern' => 'squared_thumbnail_small'
            ])
            // // Novalidation for city input
            ->get('city')->resetViewTransformers();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserMerchant::class,
        ]);
    }
}
