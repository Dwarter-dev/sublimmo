<?php

namespace App\Form;
// Entités
use App\Entity\Maison;
use App\Entity\Commercial;
// Classes
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // TextType::class, TextareaType::class, ... → passer sur Visual pour importer les class use automatiquement, Atom le fait pas
            ->add('title', TextType::class, [
                'required' => true, // à part
                'label' => 'Titre',
                'attr' => [
                     'maxLenght' => 100,
                     'placeholder' => 'Joli Maison'
                ]
              ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                     'maxLenght' => 65535,
                     'placeholder' => 'Une bien jolie maison'
                ]
              ])
            ->add('surface', IntegerType::class, [
                'required' => true,
                'label' => 'Surface (m²)',
                'attr' => [
                    'min' => 0,
                    'max' => 999,
                    'placeholder' => '150'
                ]
              ])
            ->add('rooms', IntegerType::class, [
                'required' => true,
                'label' => 'Pièces',
                'attr' => [
                     'min' => 0,
                     'max' => 99,
                     'placeholder' => '8'
                ]
              ])
            ->add('bedrooms', IntegerType::class, [
                'required' => true,
                'label' => 'Chambres',
                'attr' => [
                    'min' => 0,
                    'max' => 99,
                    'placeholder' => '2'
                ]
              ])
            ->add('price', IntegerType::class, [
                'required' => true,
                'label' => 'Prix (€)',
                'attr' => [
                    'min' => 1,
                    'max' => 1000000,
                    'placeholder' => '123 456'
                ]
              ])
            ->add('img1', FileType::class, [
                'required' => true,
                'label' => 'Image Principale',
                'help' => '.png, .jpg, .jpeg, .jp2 ou .webp - 1 Mo maximum',
                'mapped' => false,
                // dissocie ce qu'il y a dans le formulaire de ce qui est présent dans la BDD
                // empêche d'envoyer l'image et envoie uniquement le nom de l'image pour que la BDD stocke un texte à la place d'une image
                'constraints' => [ //contraintes d'envoie du fichier
                    new Image ([
                        'maxSize' => '1M', // Taille (1Mo)
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} Mo). Taille maximum : 1 Mo',
                        'mimeTypes' => [ // type
                          'image/png',
                          'image/jpg',
                          'image/jpeg',
                          'image/jp2',
                          'image/webp',
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner un format dans cette liste : .PNG, .JPG, .JPEG, .JP2 ou .WEBP'
                    ])
                  ]
            ]) // le souci principal : FileType enverra l'image dans la BDD -> conflit avec la récupération à partir de twig
            ->add('img2', FileType::class, [
                'required' => false,
                'label' => 'Image Secondaire',
                'help' => '.png, .jpg, .jpeg, .jp2 ou .webp - 1 Mo maximum',
                'mapped' => false,
                // dissocie ce qui a dans le formulaire de ce qui il a dans la BDD
                // empêche d'envoyer l'image et envoie uniquement le nom de l'image pour empêcher le conflit
                'constraints' => [ //contraintes d'envoie du fichier
                    new Image ([
                        'maxSize' => '1M', // Taille (1Mo)
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }}). Taille maximum : 1 Mo',
                        'mimeTypes' => [ // type
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
            ->add('commercial', EntityType::class, [
                'class' => Commercial::class,
                'choice_label' => 'name'
            ]) // commercial est une class (plus pércisement, une Entity) qui récupère les valeurs présentes dans la BDD commercial

            /*->add('envoyer', SubmitType::class) // le bouton peux être créer ici mais plus pratique de le manipuler dans twig*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Maison::class,
        ]);
    }
}
