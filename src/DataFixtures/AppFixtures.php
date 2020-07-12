<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        

        $users= [];

        //gestion des utisateurs
        for($i = 1; $i <= 10; $i ++){

            $content = '<p>' . join('<p></p>' , $faker->paragraphs(5)) . '</p>';
            $user = new User();
            $user->setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setEmail($faker->email())
            ->setIntroduction($faker->sentence())
            ->setDescription($content)
            ->setHash('password');

            $manager->persist($user);
            $users[] = $user;
        }

        //gestion annonce
        for($i = 1; $i < 30 ; $i++){


            $content = '<p>' . join('<p></p>' , $faker->paragraphs(5)) . '</>';
            $title = $faker->sentence();
            $user = $users[mt_rand(0,count($users)- 1)];
            
            $ad = new Ad();
            $ad->setTitle($title)

                ->setContent($content)
                ->setRooms(mt_rand(1,5))
                ->setPrice(mt_rand(40,300))
                ->setIntroduction($faker->paragraph(2))
                ->setCoverImage($faker->imageUrl(1000,350))
                ->setAuthor($user);
    
                for ($j = 1 ; $j <= mt_rand(2,5) ; $j ++){

                    $image = new Image();
                    $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                    $manager->persist($image);


                }

                $manager->persist($ad);

        }
        $manager->flush();


    }
}
