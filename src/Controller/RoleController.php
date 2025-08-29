<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\EmployeeRepository;
use App\Repository\RoleRepository;
use App\Services\Operation\RoleOperation;
use App\Services\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/roles')]

class RoleController extends AbstractController
{
    public function __construct(private readonly RoleRepository $roleRepository,
                                private readonly RoleOperation $roleOperation)

    {}

    #[Route('/', name: 'app_roles')]
    public function overviewAction(Request $request): Response
    {
        $paginator = (new Paginator($request))->setLimit(2)
                                              ->setData($this->roleRepository->findAll());
        $paginationData = $paginator->paginate();

        return $this->render('role/roles.html.twig', [
            'title' => 'Přehled rolí',
            'roles' => $paginationData['items'],
            'currentPage' => $paginationData['currentPage'],
            'totalPages' => $paginationData['totalPages'],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_role_edit', requirements: ['id' => '\d+'])]
    #[Route('/create', name: 'app_role_create', defaults: ['id' => null])]
    public function editAction(?Role $role, Request $request): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->roleOperation->save($form->getData());
            return $this->redirectToRoute('app_roles');
        }

        return $this->render('role/create_edit_form.html.twig', [
            'title' => $role ? 'Úprava role' : 'Nová role',
            'form' => $form,
            'role' => $role,
        ]);
    }
}
