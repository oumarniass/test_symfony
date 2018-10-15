<?php

namespace App\Repository;

use App\Entity\New;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method New|null find($id, $lockMode = null, $lockVersion = null)
 * @method New|null findOneBy(array $criteria, array $orderBy = null)
 * @method New[]    findAll()
 * @method New[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, New::class);
    }

//    /**
//     * @return New[] Returns an array of New objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?New
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
