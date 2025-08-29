<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

// placeholder třída dokud se neiplementuje kontakt
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        throw new HttpException(Response::HTTP_NOT_IMPLEMENTED, 'Stránka zatím nebyla implementována');
    }
}
