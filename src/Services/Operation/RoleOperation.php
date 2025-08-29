<?php

namespace App\Services\Operation;

use App\Entity\Role;

class RoleOperation extends AbstractOperation
{
    public function save(Role $role): void
    {
        $this->manager->persist($role);
        $this->manager->flush();
    }

    public function delete(Role $role): void
    {
        $this->manager->remove($role);
        $this->manager->flush();
    }
}