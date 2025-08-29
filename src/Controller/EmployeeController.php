<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeFilterType;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use App\Services\Operation\EmployeeOperation;
use App\Services\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employees')]
class EmployeeController extends AbstractController
{
    public function __construct(private readonly EmployeeRepository $employeeRepository,
                                private readonly EmployeeOperation $employeeOperation)
    {}

    #[Route('/', name: 'app_employees')]
    public function overviewAction(Request $request): Response
    {
        $form = $this->createForm(EmployeeFilterType::class, options: ['method' => 'GET']);
        $form->handleRequest($request);

        $paginator = (new Paginator($request))->setLimit(2);
        if ($form->isSubmitted() && $form->isValid()) {
            $paginator->setData($this->employeeRepository->findFiltered($form->getData()));
        } else {
            $paginator->setData($this->employeeRepository->findAll());
        }
        $paginationData = $paginator->paginate();

        return $this->render('employee/employees.html.twig', [
            'title' => 'Přehled zaměstnanců',
            'employees' => $paginationData['items'],
            'currentPage' => $paginationData['currentPage'],
            'totalPages' => $paginationData['totalPages'],
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee', requirements: ['id' => '\d+'])]
    public function detailAction(Employee $employee): Response
    {
        return $this->render('employee/employee.html.twig', [
            'title' => 'Detail zaměstnance',
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_edit', requirements: ['id' => '\d+'])]
    #[Route('/create', name: 'app_employee_create', defaults: ['id' => null])]
    public function editAction(?Employee $employee, Request $request): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $empId = $this->employeeOperation->save($form->getData());
            return $this->redirectToRoute('app_employee', ['id' => $empId]);
        }

        return $this->render('employee/create_edit_form.html.twig', [
            'title' => $employee ? 'Úprava zaměstnance' : 'Nový zaměstnanec',
            'form' => $form,
            'employee' => $employee,
        ]);
    }
}
