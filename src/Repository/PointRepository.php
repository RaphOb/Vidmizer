<?php

namespace App\Repository;

use App\Entity\Point;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

/**
 * @method Point|null find($id, $lockMode = null, $lockVersion = null)
 * @method Point|null findOneBy(array $criteria, array $orderBy = null)
 * @method Point[]    findAll()
 * @method Point[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Point::class);
    }

    public function getPointBetweenDate($id_user, $dateStart, $dateEnd)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('SUM(p.nbPoint)')
            ->andWhere('p.user = :id_user')
            ->andWhere('p.date_creation >= :dateStart')
            ->andWhere('p.date_creation <= :dateEnd')
            ->setParameters(array('id_user' =>$id_user, 'dateStart' =>$dateStart, 'dateEnd' =>$dateEnd));
            try {
            return $qb->getQuery()->getSingleScalarResult();
            } catch (NonUniqueResultException $e) {
            echo $e->getMessage();
            }
    }

    // /**
    //  * @return Point[] Returns an array of Point objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Point
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
