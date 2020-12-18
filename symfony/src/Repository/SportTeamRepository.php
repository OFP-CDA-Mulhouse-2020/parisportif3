<?php

namespace App\Repository;

use App\Entity\SportTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<TEntityClass>
 *
 * @method SportTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportTeam[]    findAll()
 * @method SportTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SportTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportTeam::class);
    }

    // /**
    //  * @return SportTeam[] Returns an array of SportTeam objects
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
    public function findOneBySomeField($value): ?SportTeam
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
