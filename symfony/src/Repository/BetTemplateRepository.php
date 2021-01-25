<?php

namespace App\Repository;

use App\Entity\BetTemplate;
use App\Entity\SportType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<TEntityClass>
 *
 * @method BetTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetTemplate[]    findAll()
 * @method BetTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BetTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetTemplate::class);
    }


    public function getBetTemplateFromSportType(SportType $sportType)
    {
        return $this->createQueryBuilder('bt')
            ->andWhere('bt.sportType = :type')
            ->setParameter("type", $sportType)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return BetTemplate[] Returns an array of BetTemplate objects
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
    public function findOneBySomeField($value): ?BetTemplate
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
