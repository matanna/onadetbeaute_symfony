<?php

namespace App\Repository;

use App\Entity\Prestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestation[]    findAll()
 * @method Prestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestation::class);
    }

    /**
     * @return Prestation[] Returns an array of Prestation objects
     */
    public function findOrderByType()
    {
        $results = $this->createQueryBuilder('p')
            ->select('p', 'pt')
            ->leftJoin('p.prestationType', 'pt')
            ->orderBy('pt.id', 'ASC')
            ->addOrderBy('p.price', 'DESC')
            ->getQuery()
            ->getResult();
        
        $sort = [];

        foreach ($results as $result) {
            if (!isset($sort[$result->getPrestationType()->getName()])) {
                $sort[$result->getPrestationType()->getName()] = [];
                $sort[$result->getPrestationType()->getName()][] = $result;
            } else {
                $sort[$result->getPrestationType()->getName()][] = $result;
            }
        }

        return $sort;
    }

    /*
    public function findOneBySomeField($value): ?Prestation
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
