<?php

namespace App\Repository;

use App\Entity\SportType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<TEntityClass>
 *
 * @method SportType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportType[]    findAll()
 * @method SportType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SportTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportType::class);
    }

    //TODO Ajouter une requête findSportEventOf($sportType)
    // pour récupérés les compétitions d'un type de sport spécifique
}
