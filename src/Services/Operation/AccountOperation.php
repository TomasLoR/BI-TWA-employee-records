<?php

namespace App\Services\Operation;

use App\Entity\Account;
use App\Entity\Employee;

class AccountOperation extends AbstractOperation
{
    public function save(Account $account): ?int
    {
        $this->manager->persist($account);
        $this->manager->flush();
        return $account->getEmployee()?->getId();
    }

    public function saveWithEmployee(Account $account, Employee $employee): int
    {
        $account->setEmployee($employee);
        $this->save($account);
        return $employee->getId();
    }

    public function delete(Account $account): ?int
    {
        $empId = $account->getEmployee()?->getId();
        $this->manager->remove($account);
        $this->manager->flush();
        return $empId;
    }

}