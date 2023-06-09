<?php

namespace App\Repository;

use App\Entity\PersonnelService;
use App\Interface\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonnelService>
 *
 * @method PersonnelService|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnelService|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnelService[]    findAll()
 * @method PersonnelService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelServiceRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonnelService::class);
    }

    public function save(PersonnelService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonnelService $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByName(string $query)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->leftJoin('s.personnel', 'p')
            ->where('p.firstname LIKE :query')
            ->orWhere('p.lastname LIKE :query')
            ->setParameter('query', "%{$query}%")
        ;
        return $qb->getQuery()->getResult();
    }
//    /**
//     * @return PersonnelService[] Returns an array of PersonnelService objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonnelService
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
