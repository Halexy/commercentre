<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchMerchantZipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('zipCode', NumberType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci d\'entrer un code postal',
                ]),
                new Regex('/^[0-9]{5}$/'),
            ],
            'attr' => [
                'class' => 'zipCode',
            ],
            'label' => 'Code postal',
            'help' => 'Exemple: 87000',
            'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
