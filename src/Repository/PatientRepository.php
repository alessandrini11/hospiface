<?php

namespace App\Repository;

use App\Entity\Patient;
use App\Interface\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function save(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Patient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByName(string $query)
    {
       return $qb = $this->createQueryBuilder('p')
            ->andWhere('p.firstname LIKE  :query')
            ->orWhere('p.lastname LIKE :query')
            ->setParameter('query', "%{$query}%")
            ->orderBy('p.firstname', 'ASC')
            ->getQuery()
            ->getResult()
           ;
    }
    public function getPatientByYears(string $targetYear)
    {
        $startDate = new \DateTime("$targetYear-01-01 00:00:00");
        $endDate = new \DateTime("$targetYear-12-31 23:59:59");
        return $this->getQueryBuilderSorted($startDate, $endDate);
    }
    public function getPatientEachMonth()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $currentDay = date('d');
        $startDate = new \DateTime("$currentYear-01-01 00:00:00");
        $endDate = new \DateTime("$currentYear-$currentMonth-$currentDay 23:59:59");
        return $this->getQueryBuilderSorted($startDate, $endDate);
    }
    private function getQueryBuilderSorted(\DateTime $startDate, \DateTime $endDate): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getResult()
            ;
    }
}
