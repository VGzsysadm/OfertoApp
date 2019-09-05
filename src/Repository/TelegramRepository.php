<?php

namespace App\Repository;

use App\Entity\Telegram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Telegram|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telegram|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telegram[]    findAll()
 * @method Telegram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelegramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telegram::class);
    }

    // /**
    //  * @return Telegram[] Returns an array of Telegram objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telegram
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
