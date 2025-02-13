<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class SortieFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('dateDebut',DateTimeType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-1.5',
                    'placeholder' => 'Sélectionner une date et heure'
                ],
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'La date de début ne peut pas être vide.'
                    ]),
                    new Assert\Type([
                        'type' => 'datetime',
                        'message' => 'La date de début doit être une date valide.',
                    ])
                ],
            ])
            ->add('dateCloture', DateTimeType::class, [
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-1.5',
                    'placeholder' => 'Sélectionner une date et heure'
                ]])
            ->add('jauge', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  p-1.5'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  p-1.5'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500'
                ]
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un lieu',
                'required' => false,
                'attr' => [
                    'class' => 'lieu-select g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5'
                ]
            ])
            ->add('lieu_ville', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('lieu_rue', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('lieu_ville', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('lieu_cp', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('lieu_latitude', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ])
            ->add('lieu_longitude', TextType::class, [
                'mapped' => false,
                'disabled' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 p-1.5",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

}