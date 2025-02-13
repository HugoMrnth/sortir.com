<?php

namespace App\Form;

use App\Data\SearchData;

use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', EntityType::class, [
                'label' => 'Site : ',
                'required' => false,
                'class' => Site::class,
                'choice_label' => 'nom',
                'placeholder' => false,
                'attr' => [
                    'class' => 'p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500',
                ]
            ])

            ->add('nomSortie', TextType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false,
                'attr' => [
                    'class' => 'ps-10 w-80 p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500',
                    'placeholder' => 'Rechercher'
                ]
            ])

            ->add('betweenDate', DateType::class,[
                'required' => false,
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'attr' => [
                    'class' => 'p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500',
                ]
            ])

            ->add('andDate', DateType::class,[
                'required' => false,
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'attr' => [
                    'class' => 'p-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500',
                ]
            ])

            ->add('isOrganisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur·rice',
                'required' => false,
            ])

            ->add('isInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit·e',
                'required' => false,
            ])

            ->add('isNotInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne participe pas',
                'required' => false,
            ])

            ->add('isPast', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
        ]);
    }

    /**
     * @return string
     * allows you to remove the ‘searchData’ prefix in order to have the simplest possible parameters in the URL
     */
    public function getBlockPrefix(): string
    {
        return '';
    }

}