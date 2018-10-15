<?php

namespace App\Repository;

use App\Entity\AcsTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AcsTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcsTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcsTable[]    findAll()
 * @method AcsTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcsTableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AcsTable::class);
    }

//    /**
//     * @return AcsTable[] Returns an array of AcsTable objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AcsTable
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
