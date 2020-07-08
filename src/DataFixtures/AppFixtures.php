<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');
        $slugyFy = new Slugify();
        
        for($i = 1; $i < 30 ; $i++){


            $content = '<p>' . join('<p></p>' , $faker->paragraphs(5)) . '</>';
            $title = $faker->sentence();
            
            $ad = new Ad();
            $ad->setTitle($title)
                ->setSlug($slugyFy->slugify($title))
                ->setContent($content)
                ->setRooms(mt_rand(1,5))
                ->setPrice(mt_rand(40,300))
                ->setIntroduction($faker->paragraph(2))
                ->setCoverImage($faker->imageUrl(1000,350));
    
                $manager->persist($ad);


        }


        $manager->flush();


    }
}
