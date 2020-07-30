<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\AbstractUtilsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractUtilsType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('rating', IntegerType::class, $this->getConfiguration("Note sur 5", "Veuillez indiquer votre de 0 à 5",[
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ]))
            ->add('content', TextareaType::class, $this->getConfiguration("Votre avis / témoignage", "N'hésitez pas à etre très précis!"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}