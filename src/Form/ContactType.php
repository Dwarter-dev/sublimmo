<?php

namespace App\Form;

// Entités
use App\Entity\Contacts;
// Classes
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => [
                     'maxLenght' => 100
                ]
              ])
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                     'maxLenght' => 100
                ]
              ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                     'maxLenght' => 100,
                ]
              ])
            ->add('objet', ChoiceType::class, [
              'required' => true,
              'choices' => [
                   '- choix' => '',
                   'déposer une annonce / estimation' => 'nouveau',
                   'postuler / rejoindre le réseau' => 'emploi',
                   'signaler un problème' => 'problème',
                   'visiter un logement' => 'visite'
              ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'attr' => [
                     'minLenght' => 50,
                     'maxLenght' => 1000,
                ]
              ])
            ->add('fichier', FileType::class, [
                'required' => false,
                'help' => '.png, .jpg, .jpeg, .jp2 ou .webp - 1 Mo maximum',
                'constraints' => [
                    new File ([
                        'maxSize' => '4096k',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Taille maximum : 4 Mo',
                        'mimeTypes' => [
                          'image/png',
                          'image/jpg',
                          'image/jpeg',
                          'image/jp2',
                          'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner un format dans cette liste : .PNG, .JPG, .JPEG, .JP2 ou .WEBP'
                    ])
                  ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
