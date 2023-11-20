<?php

namespace App\Repository;

use App\Entity\TomeCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TomeCollection>
 *
 * @method TomeCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method TomeCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method TomeCollection[]    findAll()
 * @method TomeCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TomeCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TomeCollection::class);
    }

//    /**
//     * @return TomeCollection[] Returns an array of TomeCollection objects
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

//    public function findOneBySomeField($value): ?TomeCollection
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
