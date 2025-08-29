<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class AccountDtoInput
{
    #[Serializer\Type('string')]
    public ?string $name = null;

    #[Serializer\Type('string')]
    public ?string $password = null;

    #[Serializer\Type('string')]
    public ?string $type = null;

    #[Serializer\Type("DateTimeImmutable<'Y-m-d'>")]
    public ?\DateTimeImmutable $expiration = null;

}