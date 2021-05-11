<?php

namespace App\Repository;

use App\Entity\Entertaiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entertaiment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entertaiment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entertaiment[]    findAll()
 * @method Entertaiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntertaimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entertaiment::class);
    }

    // /**
    //  * @return Entertaiment[] Returns an array of Entertaiment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entertaiment
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
