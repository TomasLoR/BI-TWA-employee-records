<?php

namespace App\Services;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Paginator
{
    private int $limit = 1;
    private array $data;
    public function __construct(private readonly Request $request)
    {}

    public function paginate() : array
    {

        $totalItems = count($this->data);
        $totalPages = ceil($totalItems / $this->limit);
        $pageParam = $this->request->query->getInt('page', 1);

        $this->validatePageParameter($pageParam, (int)$totalPages);

        return [
            'items' => $this->findPaginated($pageParam),
            'currentPage' => $pageParam,
            'totalPages' => $totalPages,
        ];
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    private function validatePageParameter(int $pageParam, int $totalPages): void
    {
        if ($pageParam < 1) {
            throw new BadRequestHttpException('Nevalidní požadavek');
        }

        if ($totalPages != 0 && $pageParam > $totalPages) {
            throw new NotFoundHttpException();
        }
    }

    private function findPaginated(int $pageParam): array
    {
        $offset = ($pageParam - 1) * $this->limit;

        return array_slice($this->data, $offset, $this->limit);
    }

}