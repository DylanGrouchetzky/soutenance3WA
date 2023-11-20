<?php

namespace App\Repository;

use App\Entity\GroupTome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupTome>
 *
 * @method GroupTome|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupTome|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupTome[]    findAll()
 * @method GroupTome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupTomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupTome::class);
    }

//    /**
//     * @return GroupTome[] Returns an array of GroupTome objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GroupTome
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
