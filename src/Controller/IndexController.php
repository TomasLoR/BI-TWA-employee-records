<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\EmployeeFilterType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct (private readonly EmployeeRepository $employeeRepository)
    {}

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $form = $this->createForm(EmployeeFilterType::class, options: [
            'method' => 'GET',
            'action' => $this->generateUrl('app_employees')]);

        return $this->render('index.html.twig',[
            'title' => 'Domů',
            'employees' => $this->employeeRepository->findNewest(3),
            'form' => $form,
        ]);
    }
}
