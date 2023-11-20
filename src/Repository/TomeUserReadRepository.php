<?php

namespace App\Repository;

use App\Entity\TomeUserRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TomeUserRead>
 *
 * @method TomeUserRead|null find($id, $lockMode = null, $lockVersion = null)
 * @method TomeUserRead|null findOneBy(array $criteria, array $orderBy = null)
 * @method TomeUserRead[]    findAll()
 * @method TomeUserRead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TomeUserReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TomeUserRead::class);
    }

//    /**
//     * @return TomeUserRead[] Returns an array of TomeUserRead objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TomeUserRead
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
