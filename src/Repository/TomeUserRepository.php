<?php

namespace App\Repository;

use App\Entity\TomeUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TomeUser>
 *
 * @method TomeUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TomeUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TomeUser[]    findAll()
 * @method TomeUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TomeUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TomeUser::class);
    }

//    /**
//     * @return TomeUser[] Returns an array of TomeUser objects
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

//    public function findOneBySomeField($value): ?TomeUser
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
