<?php

namespace App\Repository;

use App\Entity\BetChoices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BetChoices|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetChoices|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetChoices[]    findAll()
 * @method BetChoices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetChoicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetChoices::class);
    }

    // /**
    //  * @return BetChoices[] Returns an array of BetChoices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BetChoices
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
