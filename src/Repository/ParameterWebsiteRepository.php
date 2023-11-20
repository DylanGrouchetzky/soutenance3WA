<?php

namespace App\Repository;

use App\Entity\ParameterWebsite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParameterWebsite>
 *
 * @method ParameterWebsite|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParameterWebsite|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParameterWebsite[]    findAll()
 * @method ParameterWebsite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterWebsiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParameterWebsite::class);
    }

//    /**
//     * @return ParameterWebsite[] Returns an array of ParameterWebsite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParameterWebsite
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
