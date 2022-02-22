<?php

namespace App\Form;

use App\Entity\User;
// Classes
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength; // Rollerworks
// Fonctionnement
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;




class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add('first_name', TextType::class, [
              'required' => true, // à part
              'label' => 'first_name',
              'attr' => [
                   'maxLenght' => 100,
              ]
            ])
          ->add('last_name', TextType::class, [
              'required' => true, // à part
              'label' => 'last_name',
              'attr' => [
                   'maxLenght' => 100,
              ]
            ])
            ->add('email', EmailType::class, [
                'required' => true, // à part
                'label' => 'Email',
                'attr' => [
                     'maxLenght' => 100,
                ]
              ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions générales d\'utilsation.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    // new Length([
                    //     'min' => 6,
                    //     'minMessage' => 'Your password should be at least {{ limit }} characters',
                    //     // max length allowed by Symfony for security reasons
                    //     'max' => 4096,
                    // ]),
                    new PasswordStrength([
                      'minLength' => 8,
                      'tooShortMessage' => 'Le mot de passe doit contenir au moins {{ length }} caractères.',
                      'minStrength' => 4,
                      'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
