<?php

namespace App\Repository;

use App\Entity\FitnesspPartenaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FitnesspPartenaire>
 *
 * @method FitnesspPartenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method FitnesspPartenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method FitnesspPartenaire[]    findAll()
 * @method FitnesspPartenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FitnesspPartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FitnesspPartenaire::class);
    }

    public function save(FitnesspPartenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FitnesspPartenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FitnesspPartenaire[] Returns an array of FitnesspPartenaire objects
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

//    public function findOneBySomeField($value): ?FitnesspPartenaire
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}