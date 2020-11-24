<?php

namespace App\Repository;

use App\Entity\BetTemplateChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BetTemplateChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetTemplateChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetTemplateChoice[]    findAll()
 * @method BetTemplateChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetTemplateChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetTemplateChoice::class);
    }

    // /**
    //  * @return BetTemplateChoice[] Returns an array of BetTemplateChoice objects
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
    public function findOneBySomeField($value): ?BetTemplateChoice
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
