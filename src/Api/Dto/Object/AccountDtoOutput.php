<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class AccountDtoOutput
{

    #[Serializer\Type('int')]
    public int $id;

    #[Serializer\Type('string')]
    public string $name;

    #[Serializer\Type('string')]
    public string $password;

    #[Serializer\Type('string')]
    public string $type;

    #[Serializer\Type('DateTimeImmutable<"Y-m-d">')]
    public ?\DateTimeImmutable $expiration;

    #[Serializer\Type('int')]
    public ?int $employeeId;
}