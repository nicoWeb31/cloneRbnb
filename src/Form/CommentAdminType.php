<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\AbstractUtilsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentAdminType extends AbstractUtilsType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('content',TextareaType::class,$this->getConfiguration("Contenu du commentaire :",""))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
