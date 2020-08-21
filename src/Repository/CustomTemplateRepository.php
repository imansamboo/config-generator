<?php

namespace App\Repository;

use App\Entity\CustomTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CustomTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomTemplate[]    findAll()
 * @method CustomTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomTemplate::class);
    }

    // /**
    //  * @return CustomTemplate[] Returns an array of CustomTemplate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomTemplate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
