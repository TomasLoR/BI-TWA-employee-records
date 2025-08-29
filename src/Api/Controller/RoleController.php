<?php

namespace App\Api\Controller;

use App\Api\Dto\Object\RoleDtoInput;
use App\Api\Dto\Transformer\RoleTransformer;
use App\Api\Utils;
use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Services\Operation\RoleOperation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

#[Rest\Route(path: '/api/roles')]
class RoleController extends AbstractFOSRestController
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
        private readonly RoleTransformer $roleTransformer,
        private readonly RoleOperation $roleOperation,
        private readonly Utils $utils
    ) {}

    #[Rest\Get(path: '/', name: 'api_roles')]
    public function overviewAction(): Response
    {
        $roles = $this->roleRepository->findAll();
        $dto = $this->roleTransformer->entitiesToDto($roles);
        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

    #[Rest\Post(path: '/', name: 'api_role_create')]
    public function createAction(Request $request): Response
    {
        $roleDto = $this->utils->deserialize($request, RoleDtoInput::class);
        $role = $this->roleTransformer->dtoToEntity($roleDto);
        $errors = $this->utils->validate($role);

        if (count($errors) > 0) {
            return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
        }

        $this->roleOperation->save($role);
        $dto = $this->roleTransformer->entityToDto($role);
        return $this->handleView($this->view($dto, Response::HTTP_CREATED));
    }

    #[Rest\Delete(path: '/{id}', name: 'api_role_delete')]
    public function deleteAction(Role $role): Response
    {
        $this->roleOperation->delete($role);
        return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
    }
}