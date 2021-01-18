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

    //TODO Ajouter une requête findSportEventOf($team)
    // pour récupérés les compétitions où une équipe à participé
}
