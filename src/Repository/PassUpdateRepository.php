<?php

namespace App\Repository;

use App\Entity\PassUpdate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PassUpdate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PassUpdate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PassUpdate[]    findAll()
 * @method PassUpdate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassUpdateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PassUpdate::class);
    }

    // /**
    //  * @return PassUpdate[] Returns an array of PassUpdate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PassUpdate
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
