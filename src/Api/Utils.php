<?php

namespace App\Api;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Utils
{
    public function __construct(private readonly SerializerInterface $serializer,
                                private readonly ValidatorInterface $validator)
    {}

    public function deserialize(Request $request, string $dtoClassName): object
    {
        $requestData = $request->getContent();
        return $this->serializer->deserialize($requestData, $dtoClassName, 'json');
    }

    public function validate(object $dto): ConstraintViolationListInterface
    {
        return $this->validator->validate($dto);
    }
}