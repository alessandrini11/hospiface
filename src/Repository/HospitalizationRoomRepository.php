<?php

namespace App\Repository;

use App\Entity\HospitalizationRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HospitalizationRoom>
 *
 * @method HospitalizationRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method HospitalizationRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method HospitalizationRoom[]    findAll()
 * @method HospitalizationRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitalizationRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HospitalizationRoom::class);
    }

    public function save(HospitalizationRoom $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HospitalizationRoom $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HospitalizationRoomService[] Returns an array of HospitalizationRoomService objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HospitalizationRoomService
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
