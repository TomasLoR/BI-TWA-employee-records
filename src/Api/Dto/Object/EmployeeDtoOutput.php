<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class EmployeeDtoOutput
{

    #[Serializer\Type('int')]
    public int $id;

    #[Serializer\Type('string')]
    public string $name;

    #[Serializer\Type('string')]
    public ?string $email;

    #[Serializer\Type('string')]
    public ?string $phone;

    #[Serializer\Type('string')]
    public ?string $website;

    #[Serializer\Type('string')]
    public ?string $description;

    #[Serializer\Type("DateTimeImmutable<'Y-m-d'>")]
    public \DateTimeImmutable $joinedAt;

    #[Serializer\Type('array')]
    public array $roles;

    #[Serializer\Type('array')]
    public array $accounts;

}