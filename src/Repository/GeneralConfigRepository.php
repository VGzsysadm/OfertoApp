<?php

namespace App\Repository;

use App\Entity\GeneralConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GeneralConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralConfig[]    findAll()
 * @method GeneralConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralConfig::class);
    }

    // /**
    //  * @return GeneralConfig[] Returns an array of GeneralConfig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralConfig
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
