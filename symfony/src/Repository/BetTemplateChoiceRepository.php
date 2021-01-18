<?php

namespace App\Repository;

use App\Entity\BetTemplateChoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<TEntityClass>
 *
 * @method BetTemplateChoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method BetTemplateChoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method BetTemplateChoice[]    findAll()
 * @method BetTemplateChoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BetTemplateChoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BetTemplateChoice::class);
    }
}
