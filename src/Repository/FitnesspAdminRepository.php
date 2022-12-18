<?php

namespace App\Repository;

use App\Entity\FitnesspAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FitnesspAdmin>
 *
 * @method FitnesspAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method FitnesspAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method FitnesspAdmin[]    findAll()
 * @method FitnesspAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FitnesspAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FitnesspAdmin::class);
    }

    public function save(FitnesspAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FitnesspAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FitnesspAdmin[] Returns an array of FitnesspAdmin objects
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

//    public function findOneBySomeField($value): ?FitnesspAdmin
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
