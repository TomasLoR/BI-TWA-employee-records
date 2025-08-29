<?php

namespace App\Api\Controller;

use App\Api\Dto\Object\EmployeeDtoInput;
use App\Api\Dto\Transformer\EmployeeTransformer;
use App\Api\Utils;
use App\Entity\Employee;
use App\Entity\Role;
use App\Repository\EmployeeRepository;
use App\Services\Filter\EmployeeFilter;
use App\Services\Operation\EmployeeOperation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


#[Rest\Route(path: '/api/employees')]
class EmployeeController extends AbstractFOSRestController
{
    public function __construct(private readonly EmployeeRepository $employeeRepository,
                                private readonly EmployeeTransformer $employeeTransformer,
                                private readonly EmployeeOperation $employeeOperation,
                                private readonly Utils $utils)
    {}

    #[Rest\Get(path: '/', name: 'api_employees')]
    public function overviewAction(Request $request): Response
    {
        $filter = new EmployeeFilter($request->query->get('search'));
        $employees = $this->employeeRepository->findFiltered($filter);
        $dto = $this->employeeTransformer->entitiesToDto($employees);
        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

    #[Rest\Get(path: '/{id}', name: 'api_employee', requirements: ['id' => '\d+'])]
    public function detailAction(Employee $employee): Response
    {
        $dto = $this->employeeTransformer->entityToDto($employee);
        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

    #[Rest\Post(path: '/', name: 'api_employee_create')]
    public function createAction(Request $request): Response
    {
        $employeeDto = $this->utils->deserialize($request, EmployeeDtoInput::class);
        $employee = $this->employeeTransformer->dtoToEntity($employeeDto);

        $errors = $this->utils->validate($employee);
        if (count($errors) > 0) {
            return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
        }

        $this->employeeOperation->save($employee);
        $dto = $this->employeeTransformer->entityToDto($employee);

        return $this->handleView($this->view($dto, Response::HTTP_CREATED));
    }

    #[Rest\Put(path: '/{id}', name: 'api_employee_replace', requirements: ['id' => '\d+'])]
    #[Rest\Patch(path: '/{id}', name: 'api_employee_update', requirements: ['id' => '\d+'])]
    public function editAction(Request $request, Employee $employee): Response
    {
        $employeeDto = $this->utils->deserialize($request, EmployeeDtoInput::class);
        $this->employeeTransformer->dtoToExistingEntity($employeeDto, $employee, $request->getMethod());

        $errors = $this->utils->validate($employee);
        if (count($errors) > 0) {
            return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
        }

        $this->employeeOperation->save($employee);
        $dto = $this->employeeTransformer->entityToDto($employee);

        return $this->handleView($this->view($dto,  Response::HTTP_OK));
    }


    #[Rest\PUT(path: '/{employeeId}/roles/{roleId}', name: 'api_employee_role_assign', requirements: ['employeeId' => '\d+', 'roleId' => '\d+'])]
    public function assignRoleAction(#[MapEntity(id: 'employeeId')] Employee $employee,
                                     #[MapEntity(id: 'roleId')] Role $role): Response {
        if (!$this->employeeOperation->addRole($employee, $role)) {
            return $this->handleView($this->view(['error' => 'Tato role je již vlastněna tímto zaměstnancem.'],
                Response::HTTP_CONFLICT));
        }

        $dto = $this->employeeTransformer->entityToDto($employee);

        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

    #[Rest\Delete(path: '/{employeeId}/roles/{roleId}', name: 'api_employee_role_unassign', requirements: ['employeeId' => '\d+', 'roleId' => '\d+'])]
    public function unassignRoleAction(#[MapEntity(id: 'employeeId')] Employee $employee,
                                       #[MapEntity(id: 'roleId')] Role $role): Response {
        if (!$this->employeeOperation->removeRole($employee, $role)) {
            return $this->handleView($this->view(['error' => 'Tato role nebyla nalezena v rolích tohoto zaměstnance.'],
                Response::HTTP_NOT_FOUND));
        }

        $dto = $this->employeeTransformer->entityToDto($employee);

        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }


}