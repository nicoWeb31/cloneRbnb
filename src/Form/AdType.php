<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{



    /**
     * permet d'avoir la config de base d'un chapms
     * 
     */
    private function getConfiguration($label, $placeholder){

        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];

    }




    public function buildForm(FormBuilderInterface $builder, array $options)
    {




        $builder
            ->add('title',TextType::class,
                $this->getConfiguration('Titre','Tapez un super Titre pour votre annonce !')
            )
            ->add('slug',TextType::class,
                $this->getConfiguration('Adress web','Tapez Tapez l\'adresse web (facultatif) !')
            )
            ->add('introduction',TextType::class,
                $this->getConfiguration('Introduction','Donnez un introduction rapide')
            )
            ->add('content',TextareaType::class,
            $this->getConfiguration('Description détaillée','Taper une description qui donne envie ')
            )
            ->add('coverImage', UrlType::class, 
            $this->getConfiguration('Url de l\'image principale ','Donnz l\'adresse d\'une image qui fait envie')
            )
            ->add('price', MoneyType::class,
                $this->getConfiguration('Prix par nuit','Indiquer le prix pour une nuit')
            )
            ->add('rooms', IntegerType::class,
                $this->getConfiguration('Nombres de chambre','Le nombre de chambre disponibles')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
