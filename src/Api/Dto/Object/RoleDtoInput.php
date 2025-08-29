<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class RoleDtoInput
{

    #[Serializer\Type('string')]
    public ?string $name = null;

    #[Serializer\Type('bool')]
    public ?bool $isVisible = null;

    #[Serializer\Type('string')]
    public ?string $description = null;

}