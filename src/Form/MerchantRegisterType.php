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
            "commerce de détail",
            "agroalimentaire", 
            "restauration rapide",
            "loisirs, tourisme, culture",
            "informatique, internet",
            "services aux entreprises",
            "habitation",
            "textile, habillement",
            "horlogerie, bijouterie",
            "formation - administrations",
            "energie, environnement",
            "construction, bâtiment, bois",
            "matériel électrique, électronique, optique",
            "métallurgie, mécanique",
            "chimie, plastique, santé", 
            "papier, impression",
            "transports et logistique",
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
                'help' => 'Exemple: 75016',
                'attr' => [
                    'class' => 'zipCode',
                ]
            ])
            ->add('city', ChoiceType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'city',
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'help' => 'Exemple : 6XXXXXXXX',
                'attr' => [
                    'placeholder' => '+33',
                ]
                
            ])  
            ->add('description', TextareaType::class)      
            ->add('additionalInformation', TextareaType::class, [
                'label' => 'Informations supplémentaires'
            ])
            ->add('siretNumber', TextType::class, [
                'label' => 'Numéro de siret',
                'help' => '14 chiffres sans espace',
            ])     
            ->add('category', ChoiceType::class, array(
                'label' => 'Secteur d\'activité',
                'help' => 'Exemple: Boulangerie',
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
