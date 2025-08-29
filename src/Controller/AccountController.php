<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Employee;
use App\Form\AccountType;
use App\Form\DeleteType;
use App\Services\Operation\AccountOperation;
use App\Services\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/accounts')]
class AccountController extends AbstractController
{
    public function __construct(private readonly AccountOperation $accountOperation)
    {}

    #[Route('/{id}', name: 'app_accounts', requirements: ['id' => '\d+'])]
    public function detailAction(Employee $employee, Request $request): Response
    {
        $paginator = (new Paginator($request))->setLimit(4)
                                              ->setData($employee->getAccounts()->toArray());
        $paginationData = $paginator->paginate();

        $form = $this->createForm(AccountType::class, options: [
            'method' => 'POST',
            'action' => $this->generateUrl('app_account_create', ['id' => $employee->getId()]),
        ]);

        return $this->render('account/accounts.html.twig', [
            'title' => 'Detail účtů',
            'employee' => $employee,
            'accounts' => $paginationData['items'],
            'currentPage' => $paginationData['currentPage'],
            'totalPages' => $paginationData['totalPages'],
            'form' => $form,
        ]);
    }

    #[Route('/{id}/create', name: 'app_account_create', requirements: ['id' => '\d+'])]
    public function createAction(Employee $employee, Request $request): Response
    {
        $form = $this->createForm(AccountType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empId = $this->accountOperation->saveWithEmployee($form->getData(), $employee);

            return $this->redirectToRoute('app_accounts', ['id' => $empId]);
        }

        return $this->render('account/create_edit_form.html.twig', [
            'title' => 'Nový účet',
            'form' => $form,
            'account' => null,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_account_edit', requirements: ['id' => '\d+'])]
    public function editAction(Account $account, Request $request): Response
    {
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empId = $this->accountOperation->save($form->getData());
            return $this->redirectToRoute('app_accounts', ['id' => $empId]);
        }

        return $this->render('account/create_edit_form.html.twig', [
            'title' => 'Úprava účtu',
            'form' => $form,
            'account' => $account,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_account_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(Account $account, Request $request): Response
    {
        $form = $this->createForm(DeleteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empId = $this->accountOperation->delete($account);
            return $this->redirectToRoute('app_accounts', ['id' => $empId]);
        }

        return $this->render('account/delete.html.twig', [
            'title' => 'Odstranit účet',
            'form' => $form,
            'account' => $account,
        ]);
    }
}
