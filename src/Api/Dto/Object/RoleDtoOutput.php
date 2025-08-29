<?php

namespace App\Api\Dto\Object;

use JMS\Serializer\Annotation as Serializer;

class RoleDtoOutput
{

    #[Serializer\Type('int')]
    public int $id;

    #[Serializer\Type('string')]
    public string $name;

    #[Serializer\Type('bool')]
    public bool $isVisible;

    #[Serializer\Type('string')]
    public ?string $description;

    #[Serializer\Type('array')]
    public array $employeeIds;

}