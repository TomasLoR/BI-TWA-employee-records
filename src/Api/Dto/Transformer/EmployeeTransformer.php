<?php

namespace App\Api\Dto\Transformer;

use App\Api\Dto\Object\EmployeeDtoOutput;
use App\Api\Dto\Object\EmployeeDtoInput;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;

class EmployeeTransformer
{
    public function __construct(private readonly RoleTransformer    $roleTransformer,
                                private readonly AccountTransformer $accountTransformer)
    {}

    public function entitiesToDto (iterable $employees): array
    {
        $dtoArr = [];

        foreach ($employees as $employee) {
            $dtoArr[] = $this->entityToDto($employee);
        }

        return $dtoArr;
    }

    public function entityToDto (Employee $employee): EmployeeDtoOutput
    {
        $dto = new EmployeeDtoOutput();

        $dto->id = $employee->getId();
        $dto->name = $employee->getName();
        $dto->email = $employee->getEmail();
        $dto->phone = $employee->getPhone();
        $dto->website = $employee->getWebsite();
        $dto->description = $employee->getDescription();
        $dto->joinedAt = $employee->getJoinedAt();
        $dto->roles = $this->roleTransformer->entitiesToDto($employee->getRoles());
        $dto->accounts = $this->accountTransformer->entitiesToDto($employee->getAccounts());

        return $dto;
    }
    public function dtoToEntity (EmployeeDtoInput $dto): Employee
    {
        return (new Employee())
            ->setName($dto->name)
            ->setEmail($dto->email)
            ->setPhone($dto->phone)
            ->setWebsite($dto->website)
            ->setDescription($dto->description)
            ->setJoinedAt($dto->joinedAt)
            ->setPhotoUrl($dto->photoUrl);
    }

    public function dtoToExistingEntity (EmployeeDtoInput $dto, Employee $employee, string $method): Employee
    {
        if ($dto->name !== null || $method == Request::METHOD_PUT) {
            $employee->setName($dto->name);
        }

        if ($dto->email !== null || $method == Request::METHOD_PUT) {
            $employee->setEmail($dto->email);
        }

        if ($dto->phone !== null || $method == Request::METHOD_PUT) {
            $employee->setPhone($dto->phone);
        }

        if ($dto->website !== null || $method == Request::METHOD_PUT) {
            $employee->setWebsite($dto->website);
        }

        if ($dto->description !== null || $method == Request::METHOD_PUT) {
            $employee->setDescription($dto->description);
        }

        if ($dto->joinedAt !== null || $method == Request::METHOD_PUT) {
            $employee->setJoinedAt($dto->joinedAt);
        }

        if ($dto->photoUrl !== null || $method == Request::METHOD_PUT) {
            $employee->setPhotoUrl($dto->photoUrl);
        }

        return $employee;
    }
}