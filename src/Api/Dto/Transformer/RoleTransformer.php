<?php

namespace App\Api\Dto\Transformer;

use App\Api\Dto\Object\RoleDtoInput;
use App\Api\Dto\Object\RoleDtoOutput;
use App\Entity\Role;

class RoleTransformer
{

    public function entitiesToDto (iterable $roles): array
    {
        $dtoArr = [];

        foreach ($roles as $role) {
            $dtoArr[] = $this->entityToDto($role);
        }

        return $dtoArr;
    }

    public function entityToDto(Role $role): RoleDtoOutput
    {
        $dto = new RoleDtoOutput();

        $dto->id = $role->getId();
        $dto->name = $role->getName();
        $dto->description = $role->getDescription();
        $dto->isVisible = $role->getIsVisible();
        $dto->employeeIds = $role->getEmployees()->map(fn($employee) => $employee->getId())->toArray();

        return $dto;
    }

    public function dtoToEntity(RoleDtoInput $dto): Role
    {
        return (new Role())
            ->setName($dto->name)
            ->setIsVisible($dto->isVisible)
            ->setDescription($dto->description);
    }
}