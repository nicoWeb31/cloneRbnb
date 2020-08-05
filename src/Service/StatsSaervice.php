<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsSaervice {

    private $manager;

    public function __construct(EntityManagerInterface $man)
    {
        $this->manager = $man;
    }


    /**
     * permet de recupérer le nbr d'entrée
     */

    public function getUserCount()
    {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    /**
     * permet de recupérer le nbr d'entrée
     */

    public function getAdsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();
    }

    /**
     * permet de recupérer le nbr d'entrée
     */

    public function getBookingsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
    }

    /**
     * permet de recupérer le nbr d'entrée
     */

    public function getCommentCount()
    {
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }



    /**
     * Undocumented function
     *
     * @return array
     */

    public function getStats()
    {
        $users = $this->getUserCount();
        $ads = $this->getAdsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentCount();

        return compact('users','ads','bookings','comments');
    }


    // /**
    //  * retourne les  5 meilleur annonces
    //  * @return  array
    //  */

    // public function getBestAds(){

    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note,a.title, a.id , u.firstName, u.picture, u.lastName
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN a.author u
    //         GROUP BY a
    //         ORDER BY note DESC
    //         ' 
    //     )->setMaxResults(5)->getResult();
    // }


    // /**
    //  * return five worst ads
    //  */

    // public function getWorsAds()
    // {
    //     return $this->manager->createQuery(
    //         'SELECT AVG(c.rating) as note,a.title, a.id , u.firstName, u.picture, u.lastName
    //         FROM App\Entity\Comment c
    //         JOIN c.ad a
    //         JOIN a.author u
    //         GROUP BY a
    //         ORDER BY note ASC
    //         ' 
    //     )->setMaxResults(5)->getResult();

    // }


    /**
     * return five worst ads
     */

    public function getWorsOrBestAds($order)
    {
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note,a.title, a.id , u.firstName, u.picture, u.lastName
            FROM App\Entity\Comment c
            JOIN c.ad a
            JOIN a.author u
            GROUP BY a
            ORDER BY note '.$order 
        )->setMaxResults(5)->getResult();

    }







}    