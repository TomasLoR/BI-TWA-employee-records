<?php

namespace App\Api\Controller;

use App\Api\Dto\Object\AccountDtoInput;
use App\Api\Dto\Transformer\AccountTransformer;
use App\Api\Dto\Transformer\EmployeeTransformer;
use App\Api\Utils;
use App\Entity\Account;
use App\Entity\Employee;
use App\Services\Operation\AccountOperation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

#[Rest\Route(path: '/api/employees')]
class AccountController extends AbstractFOSRestController
{
    public function __construct(private readonly AccountTransformer $accountTransformer,
                                private readonly AccountOperation $accountOperation,
                                private readonly EmployeeTransformer $employeeTransformer,
                                private readonly Utils $utils)
    {}

    #[Rest\Get(path: '/{id}/accounts', name: 'api_accounts')]
    public function overviewAction(Employee $employee): Response
    {
        $accounts = $employee->getAccounts();
        $dto = $this->accountTransformer->entitiesToDto($accounts);
        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

    #[Rest\Post(path: '/{id}/accounts', name: 'api_account_create')]
    public function createAction(Request $request, Employee $employee): Response
    {
        $accountDto = $this->utils->deserialize($request, AccountDtoInput::class);
        $account = $this->accountTransformer->dtoToEntity($accountDto);
        $errors = $this->utils->validate($account);

        if (count($errors) > 0) {
            return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
        }

        $this->accountOperation->saveWithEmployee($account, $employee);
        $dto = $this->accountTransformer->entityToDto($account);

        return $this->handleView($this->view($dto, Response::HTTP_CREATED));

    }

/*
    #[Rest\Put(path: '/{id}', name: 'api_account_replace', requirements: ['id' => '\d+'])]
    #[Rest\Patch(path: '/{id}', name: 'api_account_update', requirements: ['id' => '\d+'])]
    public function editAction(Request $request, Account $account): Response
    {
        $accountDto = $this->utils->deserialize($request, AccountDtoInput::class);
        $this->accountTransformer->dtoToExistingEntity($accountDto, $account, $request->getMethod());

        $errors = $this->utils->validate($account);
        if (count($errors) > 0) {
            return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
        }

        $this->accountOperation->save($account);
        $dto = $this->accountTransformer->entityToDto($account);

        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }
*/
    #[Rest\Delete(path: '/{employeeId}/accounts/{accountId}', name: 'api_account_delete',
        requirements: ['employeeId' => '\d+', 'accountId' => '\d+'])]
    public function deleteAction(#[MapEntity(id: 'employeeId')] Employee $employee,
                                 #[MapEntity(id: 'accountId')] Account $account): Response
    {
        $this->accountOperation->delete($account);
        $dto = $this->employeeTransformer->entityToDto($employee);


        return $this->handleView($this->view($dto, Response::HTTP_OK));
    }

}