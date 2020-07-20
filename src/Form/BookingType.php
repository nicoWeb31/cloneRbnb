<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\AbstractUtilsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractUtilsType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('startDate', DateType::class, $this->getConfiguration("Date d'arrivée","Votre date d'arrivée" ) )
            ->add('endDate', DateType::class, $this->getConfiguration("Date de depart", "Votre date de départ"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
