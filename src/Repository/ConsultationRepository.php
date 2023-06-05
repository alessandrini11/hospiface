<?php

namespace App\Repository;

use App\Entity\Consultation;
use App\Interface\EntityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 *
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository implements EntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    public function save(Consultation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Consultation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByName(string $query)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftJoin('c.patient', 'p')
            ->leftJoin('c.doctor', 'd')
            ->where('p.firstname LIKE :query')
            ->orWhere('p.lastname LIKE :query')
            ->orWhere('d.firstname LIKE :query')
            ->orWhere('d.lastname LIKE :query')
            ->setParameter('query', "%{$query}%");
        return $qb->getQuery()->getResult();
    }
    public function getConsultationByYears(string $targetYear)
    {
        $startDate = new \DateTime("$targetYear-01-01 00:00:00");
        $endDate = new \DateTime("$targetYear-12-31 23:59:59");
        return $this->getQueryBuilderSorted($startDate, $endDate);
    }
    public function getConsultationEachMonth()
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
