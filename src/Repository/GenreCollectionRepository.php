<?php

namespace App\Repository;

use App\Entity\GenreCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GenreCollection>
 *
 * @method GenreCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenreCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenreCollection[]    findAll()
 * @method GenreCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenreCollection::class);
    }

//    /**
//     * @return GenreCollection[] Returns an array of GenreCollection objects
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

//    public function findOneBySomeField($value): ?GenreCollection
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
