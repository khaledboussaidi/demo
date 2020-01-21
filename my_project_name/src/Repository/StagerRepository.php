<?php

namespace App\Repository;

use App\Entity\Stager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stager|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stager|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stager[]    findAll()
 * @method Stager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stager::class);
    }

    // /**
    //  * @return Stager[] Returns an array of Stager objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stager
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
