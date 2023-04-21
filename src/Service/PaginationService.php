<?php

namespace App\Service;

class PaginationService
{
    public function getPaginatedItems($perPage, $actualPage, $repository): array
    {
        $offset = $actualPage == 1 ? 0 : abs($perPage) * (abs($actualPage) - 1);
        $data = $repository->findBy([], [], $perPage, $offset);
        $totalPages = ceil(count($repository->findAll())/$perPage);
        return [
            'data' => $data,
            'page' => $actualPage,
            'perPage' => $perPage,
            'totalPages' => $totalPages
        ];
    }
}