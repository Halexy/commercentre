<?php

namespace App\Form;

use App\Entity\UserMerchant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MerchantRegister extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $array = array(
            "Commerce de véhicules automobiles", 
            "Entretien et réparation de véhicules automobiles", 
            "Commerce d'équipements automobiles",
            "Commerce et réparation de motocycles",
            "Commerce de détail en magasin non spécialisé",
            "Commerce de détail alimentaire en magasin spécialisé",
            "Commerce de détail de carburants en magasin spécialisé",
            "Commerce de détail d'équipements de l'information et de la communication en magasin spécialisé",
            "Commerce de détail d'autres équipements du foyer en magasin spécialisé",
            "Commerce de détail de biens culturels et de loisirs en magasin spécialisé",
            "Autres commerces de détail en magasin spécialisé",
            "Commerce de détail sur éventaires et marchés",
            "Hôtels et hébergement similaire",
            "Hébergement touristique et autre hébergement de courte durée ",
            "Restaurants et services de restauration mobile",
            "Traiteurs et autres services de restauration",
            "Débits de boissons",
            "Programmation, conseil et autres activités informatiques ",
            "Assurance",
            "Activités des marchands de biens immobiliers",
            "Publicité",
            "Activités photographiques",
            "Activités vétérinaires",
            "Activités des agences de voyage et voyagistes",
            "Activités de nettoyage",
            "Activités créatives, artistiques et de spectacle",
            "Bibliothèques, archives, musées et autres activités culturelles",
            "Réparation d'ordinateurs et d'équipements de communication",
            "Réparation de biens personnels et domestiques",
            "Autres services personnels"
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
                'help' => 'Exemple: 75000',
                'attr' => [
                    'class' => 'zipCode',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un code postal',
                    ]),
                    new Regex('/^[0-9]{5}$/'),
                ]
            ])
            ->add('city', ChoiceType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'city',
                ]
            ])
            ->add('phoneNumber', TelType::class, [
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
                'label' => 'Type d\'activité',
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
            // Novalidation for city input
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
