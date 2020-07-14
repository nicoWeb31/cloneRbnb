<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractUtilsType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {




        $builder
            ->add('title',TextType::class,
                $this->getConfiguration('Titre','Tapez un super Titre pour votre annonce !')
            )
            ->add('slug',TextType::class,
                $this->getConfiguration('Adress web','Tapez Tapez l\'adresse web (facultatif) !',[
                    'required' => false
                ])
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

            //collection d'image
            ->add('images', CollectionType::class,[

                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
