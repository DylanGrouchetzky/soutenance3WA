<?php

namespace App\Repository;

use App\Entity\CollectionLibrary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CollectionLibrary>
 *
 * @method CollectionLibrary|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionLibrary|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionLibrary[]    findAll()
 * @method CollectionLibrary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionLibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionLibrary::class);
    }

//    /**
//     * @return CollectionLibrary[] Returns an array of CollectionLibrary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CollectionLibrary
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getRandomCollection($category, $id){
        $query = $this->createQueryBuilder('c');
        $query->andWhere('c.categoryCollection = :category')
            ->andWhere($query->expr()->neq('c.id', ':id'))
            ->orderBy('RAND()')
            ->setMaxResults(4)
            ->setParameter('category', $category)
            ->setParameter('id', $id)
        ;
        return $query->getQuery()->getResult();
    }
}
