<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{

    public function __construct()
    {}
    public function errorAction(Request $request, FlattenException $exception): Response
    {
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage();

        if($statusCode === Response::HTTP_NOT_FOUND) {
            $message = 'Stránka nebyla nalezena';
        }

        return $this->render('bundles/TwigBundle/Exception/error.html.twig', [
            'title' => 'Chyba',
            'code' => $statusCode,
            'message' => $message,
        ]);
    }
}
