<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ParticipantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ]])
            ->add('prenom', TextType::class, [
                'required' => true,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ]])
            ->add('nom', TextType::class, [
                'required' => false,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ]])
            ->add('telephone', TextType::class, [
                'required' => false,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ]])
            ->add('email', TextType::class, [
                'required' => false,
                "attr" => [
                    "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ]])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",],
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Le mot de passe doit être de {{ limit }} characters minimum.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),

                ],

            ])
        ->add('confirm', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', "class" => "bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5",
                ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
