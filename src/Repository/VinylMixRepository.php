<?php

namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<VinylMix>
 */
class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

        /**
         * @return VinylMix[] Returns an array of VinylMix objects
         */
        public function findAllOrderedByVotes(string $genre = null): array
        {
            $queryBuilder = $this->addOrderByVotesQueryBuilder();
            if ($genre) {
                $queryBuilder->andWhere('mix.genre = :genre')
                    ->setParameter('genre', $genre);
            }
            return $queryBuilder
                ->getQuery()
                ->getResult()
            ;
        }
        
        public function createOrderedByVotesQueryBuilder(string $genre = null): QueryBuilder
    {
        $queryBuilder = $this->addOrderByVotesQueryBuilder();
        if ($genre) {
            $queryBuilder->andWhere('mix.genre = :genre')
                ->setParameter('genre', $genre);
        }
        return $queryBuilder;
    }

        private function addOrderByVotesQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
        {
            $queryBuilder = $queryBuilder ?? $this->createQueryBuilder('mix');
            return $queryBuilder->orderBy('mix.votes', 'DESC');
        }

    //    public function findOneBySomeField($value): ?VinylMix
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
