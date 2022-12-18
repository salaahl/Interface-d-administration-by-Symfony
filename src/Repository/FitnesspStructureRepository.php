<?php

namespace App\Repository;

use App\Entity\FitnesspStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FitnesspStructure>
 *
 * @method FitnesspStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method FitnesspStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method FitnesspStructure[]    findAll()
 * @method FitnesspStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FitnesspStructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FitnesspStructure::class);
    }

    public function save(FitnesspStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FitnesspStructure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FitnesspStructure[] Returns an array of FitnesspStructure objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FitnesspStructure
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
