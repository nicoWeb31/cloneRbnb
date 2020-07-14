<?php

namespace App\Form;

use App\Entity\User;
use App\Form\AbstractUtilsType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractUtilsType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class, $this->getConfiguration('Prénom', "Votre prénom ..."))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille ..."))
            ->add('email',EmailType::class, $this->getConfiguration("Email", "votre email ..."))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo", "url de votre avatar ..."))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Choisissez un bon mot de passe ..."))
            ->add('passwordConfirm', PasswordType::class,$this->getConfiguration("Confirmation de mot de passe","Confirmer mot de passe "))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Présentez vous en quelque mots ..."))
            ->add('description', TextType::class, $this->getConfiguration("Description Détaillée","C'est le moment de vous preparer"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
