<?php

namespace App\Repository;

use App\Entity\Hospitilization;
use App\Interface\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hospitilization>
 *
 * @method Hospitilization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospitilization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospitilization[]    findAll()
 * @method Hospitilization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitilizationRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospitilization::class);
    }

    public function save(Hospitilization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Hospitilization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function searchByName(string $query)
    {
        $qb = $this->createQueryBuilder('h');
        $qb->leftJoin('h.patient', 'p')
            ->where('p.firstname LIKE :query')
            ->orWhere('p.lastname LIKE :query')
            ->setParameter('query', "%{$query}%");
        return $qb->getQuery()->getResult();
    }
}
