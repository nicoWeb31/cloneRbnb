<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;





class AbstractUtilsType extends AbstractType{


    
        /**
         * permet d'avoir la config de base d'un chapms
         * 
         */
        protected function getConfiguration($label, $placeholder, $option=[]){
    
            //array merge fusionne deux tableaux
            return array_merge_recursive([
                'label' => $label,
                'attr' => [
                    'placeholder' => $placeholder
                ]
                ],$option);
    
        }




}


