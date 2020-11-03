<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function find10NewestReports(): ArrayCollection
    {
        return $this->createQueryBuilder('report')
            ->orderBy('report.created_at', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function save(Report $report): Report
    {
        try {
            $this->getEntityManager()->persist($report);
        } catch (ORMException $e) {
            throw new Exception($e->getMessage());
        }

        $this->getEntityManager()->flush();

        return $report;
    }
}
