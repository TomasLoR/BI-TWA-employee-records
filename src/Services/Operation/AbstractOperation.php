<?php
declare(strict_types=1);

namespace App\Services\Operation;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractOperation
{

    public function __construct(protected EntityManagerInterface $manager)
    {}

}
