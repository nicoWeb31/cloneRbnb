<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\AbstractUtilsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractUtilsType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('startDate', DateType::class, $this->getConfiguration("Date d'arrivée","Votre date d'arrivée",["widget" => "single_text"]))
            ->add('endDate', DateType::class, $this->getConfiguration("Date de depart", "Votre date de départ",["widget" => "single_text"]))
            ->add('comment', TextareaType::class, $this->getConfiguration(false,"Si vous avez un commentaire n'hétez pas à nous en faire part !",["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
