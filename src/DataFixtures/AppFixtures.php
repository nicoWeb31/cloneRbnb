<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        
        for($i = 1; $i < 30 ; $i++){
            
            $ad = new Ad();
            $ad->setTitle("titre de l\'annonce n $i")
                ->setSlug("titre-annonce-$i")
                ->setContent('je suis un content')
                ->setRooms(mt_rand(4,10))
                ->setPrice(mt_rand(20,300))
                ->setIntroduction("ceci est une intro n $i")
                ->setCoverImage('http://placehold.it/1000x300');
    
                $manager->persist($ad);


        }


        $manager->flush();


    }
}
