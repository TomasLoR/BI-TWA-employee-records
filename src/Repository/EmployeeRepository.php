<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Services\Filter\EmployeeFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findNewest(int $count): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.joinedAt', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    public function findFiltered(EmployeeFilter $filter): array
    {
        $qBuilder = $this->createQueryBuilder('e');
        return $filter->initiate($qBuilder)->getQuery()->getResult();
    }
}
