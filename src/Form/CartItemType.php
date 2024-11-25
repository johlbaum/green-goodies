<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'required' => true,
                'label' => 'Quantité :',
                'attr' => [
                    'min' => 0, // On définit une valeur minimale autorisée pour ce champ.
                ],
                'data' => $options['quantity'] // On initialise la valeur du champ avec la valeur passée dans l'option.
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quantity' => 1 // Par défaut, le champ est initialisé à 1.
        ]);
    }
}
