<?php

namespace App\Repository;

use App\Entity\BetTemplate;
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
}
