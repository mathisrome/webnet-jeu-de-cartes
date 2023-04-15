<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Unique;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbCards', IntegerType::class, [
                'label' => 'Nombre de cartes',
                'attr' => [
                    'min' => 2,
                    'max' => 52,
                ]
            ])
            ->add('colors', CollectionType::class, [
                'label' => 'Couleurs',
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-select'
                    ],
                    'choices' => Game::COLORS,
                    'choice_label' => function ($choice) {
                        return $choice;
                    }
                ],
                'entry_type' => ChoiceType::class,
            ])
            ->add('valeurs', CollectionType::class, [
                'label' => 'Valeurs',
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'form-select'
                    ],
                    'choices' => Game::VALEURS,
                    'choice_label' => function ($choice) {
                        return $choice;
                    }
                ],
                'entry_type' => ChoiceType::class,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Commercez la partie',
                'attr' => [
                    'class' => 'btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
