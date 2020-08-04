<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('endDate',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('comment')
            // relier un entité 
            ->add('booker',EntityType::class,[
                
                'class'=>User::class,                        //quel class
                'choice_label'=> function($user){            //label
                    return $user->getFirstName(). " " .strtoupper($user->getLastName());
                }                             
            ])
            ->add('ad',EntityType::class,[
                'class' => Ad::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
