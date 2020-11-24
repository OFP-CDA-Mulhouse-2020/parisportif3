<?php

namespace App\Repository;

use App\Entity\EncounterEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EncounterEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method EncounterEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method EncounterEvent[]    findAll()
 * @method EncounterEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncounterEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EncounterEvent::class);
    }

    // /**
    //  * @return EncounterEvent[] Returns an array of EncounterEvent objects
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
    public function findOneBySomeField($value): ?EncounterEvent
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
