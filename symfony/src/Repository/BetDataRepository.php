<?php

namespace App\Repository;

use App\Entity\BetData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<TEntityClass>
 *
 * @method BetData|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetData|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetData[]    findAll()
 * @method BetData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BetDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetData::class);
    }

    // /**
    //  * @return BetData[] Returns an array of BetData objects
    //  */
    /*
     *
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
    public function findOneBySomeField($value): ?BetData
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
