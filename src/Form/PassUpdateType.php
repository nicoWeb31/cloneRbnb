<?php

namespace App\Form;


use App\Form\AbstractUtilsType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PassUpdateType extends AbstractUtilsType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',PasswordType::class, $this->getConfiguration("Ancien mot de passe", "Donnez votre mot de passe actuel ..."))
            ->add('newPass', PasswordType::class, $this->getConfiguration("Nouveau mot de passe", "Tapz votre nouveau mot de passe"))
            ->add('ComfirmPass', PasswordType::class, $this->getConfiguration("Confirmer mot de passe", "Confirmer votre nouveau mot de passe"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
