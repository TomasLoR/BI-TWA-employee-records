<?php

namespace App\Services\Operation;


use App\Entity\Employee;
use App\Entity\Role;

class EmployeeOperation extends AbstractOperation
{
    public function save(Employee $employee): int
    {
        $this->manager->persist($employee);
        $this->manager->flush();
        return $employee->getId();
    }

    public function removeRole(Employee $employee, Role $role): bool
    {
        if (!$employee->getRoles()->contains($role)) {
            return false;
        }

        $employee->removeRole($role);
        $this->manager->flush();
        return true;
    }

    public function addRole(Employee $employee, Role $role): bool
    {
        if ($employee->getRoles()->contains($role)) {
            return false;
        }

        $employee->addRole($role);
        $this->manager->flush();
        return true;
    }

}