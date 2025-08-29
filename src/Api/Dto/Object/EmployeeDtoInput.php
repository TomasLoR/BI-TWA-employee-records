<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class EmployeeDtoInput
{

    #[Serializer\Type('string')]
    public ?string $name = null;

    #[Serializer\Type('string')]
    public ?string $email = null;

    #[Serializer\Type('string')]
    public ?string $phone = null;

    #[Serializer\Type('string')]
    public ?string $website = null;

    #[Serializer\Type('string')]
    public ?string $description = null;

    #[Serializer\Type("DateTimeImmutable<'Y-m-d'>")]
    public ?\DateTimeImmutable $joinedAt = null;

    #[Serializer\Type('string')]
    public ?string $photoUrl = null;

}