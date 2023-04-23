<?php

namespace App\Service;

use App\model\PaginationModel;

class PaginationService
{
    public function getPaginatedItems(PaginationModel $paginationModel, $repository): array
    {
        $actualPage = $paginationModel->actualPage;
        $perPage = $paginationModel->perPage;
        $query = $paginationModel->query;
        $offset = $actualPage == 1 ? 0 : abs($perPage) * (abs($actualPage) - 1);
        $data = $repository->findBy([], ['createdAt' => 'DESC'], $perPage, $offset);
        $totalPages = ceil(count($repository->findAll())/$perPage);
        if($query){
            $data = $repository->searchByName($query);
        }
        return [
            'data' => $data,
            'page' => !$query ? $actualPage : null,
            'perPage' => !$query ? $perPage : null,
            'totalPages' => !$query ? $totalPages : null
        ];
    }
}