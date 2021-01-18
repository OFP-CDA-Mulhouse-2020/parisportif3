<?php

namespace App\Repository;

use App\Entity\BetChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends ServiceEntityRepository<TEntityClass>
 *
 * @method BetChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetChoice[]    findAll()
 * @method BetChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BetChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetChoice::class);
    }
}
