<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\AbstractUtilsType;
use App\Form\dataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractUtilsType
{


    private $transformer;


    public function __construct(FrenchToDateTimeTransformer $tranforme)
    {
        $this->transformer = $tranforme;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('startDate', TextType::class, $this->getConfiguration("Date d'arrivée","Votre date d'arrivée"))
            ->add('endDate', TextType::class, $this->getConfiguration("Date de depart", "Votre date de départ"))
            ->add('comment', TextareaType::class, $this->getConfiguration(false,"Si vous avez un commentaire n'hétez pas à nous en faire part !",["required" => false]))
        ;


        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            //possiblilité de noter les groupes de validation
            'Validation_groups' => ["Default", "front"]
        ]);
    }
}
