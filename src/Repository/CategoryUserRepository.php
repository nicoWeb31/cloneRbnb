<?php

namespace App\Repository;

use App\Entity\CategoryUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryUser[]    findAll()
 * @method CategoryUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryUser::class);
    }

    // /**
    //  * @return CategoryUser[] Returns an array of CategoryUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryUser
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
