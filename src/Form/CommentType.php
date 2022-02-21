<?php

namespace App\Form;
// Entités
use App\Entity\Comment;
use App\Entity\Maison;
// Classes
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// Fonctionnement
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextType::class, [
                'required' => true, // à part
                'label' => 'Commentaire',
                'attr' => [
                     'maxLenght' => 255
                ]
              ])
            ->add('maison', EntityType::class, [
                'class' => Maison::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
