<?php

namespace App\Api\Dto\Transformer;

use App\Api\Dto\Object\AccountDtoInput;
use App\Api\Dto\Object\AccountDtoOutput;
use App\Entity\Account;
use App\Entity\EnumType;
use Symfony\Component\HttpFoundation\Request;

class AccountTransformer
{
    public function entitiesToDto (iterable $accounts): array
    {
        $dtoArr = [];

        foreach ($accounts as $account) {
            $dtoArr[] = $this->entityToDto($account);
        }

        return $dtoArr;
    }

    public function entityToDto(Account $account): AccountDtoOutput
    {
        $dto = new AccountDtoOutput();

        $dto->id = $account->getId();
        $dto->name = $account->getName();
        $dto->password = $account->getPassword();
        $dto->type = $account->getType()->getLabel();
        $dto->expiration = $account->getExpiration();
        $dto->employeeId = $account->getEmployee()?->getId();

        return $dto;
    }

    public function dtoToEntity (AccountDtoInput $dto): Account
    {
        return (new Account())
            ->setName($dto->name)
            ->setPassword($dto->password)
            ->setType($dto->type ? EnumType::from($dto->type) : null)
            ->setExpiration($dto->expiration);
    }

    public function dtoToExistingEntity(AccountDtoInput $dto, Account $account, string $method): Account
    {
        if ($dto->name !== null || $method == Request::METHOD_PUT) {
            $account->setName($dto->name);
        }

        if ($dto->password !== null || $method == Request::METHOD_PUT) {
            $account->setPassword($dto->password);
        }

        if ($dto->type !== null || $method == Request::METHOD_PUT) {
            $account->setType($dto->type ? EnumType::from($dto->type) : null);
        }

        if ($dto->expiration !== null || $method == Request::METHOD_PUT) {
            $account->setExpiration($dto->expiration);
        }

        return $account;
    }

}