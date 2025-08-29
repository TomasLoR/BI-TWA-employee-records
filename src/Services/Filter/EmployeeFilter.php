<?php

namespace App\Services\Filter;

use Doctrine\ORM\QueryBuilder;

class EmployeeFilter
{
    public function __construct(
        public ?string $search = null
    ) {}

    public function initiate(QueryBuilder $qBuilder): QueryBuilder
    {
        if ($this->search) {
            $qBuilder->join('e.roles', 'r')
                     ->where('e.name LIKE :search')
                     ->orWhere('e.email LIKE :search')
                     ->orWhere('e.phone LIKE :search')
                     ->orWhere('e.website LIKE :search')
                     ->orWhere('e.description LIKE :search')
                     ->orWhere('r.name LIKE :search')
                     ->setParameter('search', '%' . $this->search . '%');
        }

        return $qBuilder;
    }

}