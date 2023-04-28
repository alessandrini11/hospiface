<?php

namespace App\Service;

use App\DTO\PatientRequest;
use App\DTO\PatientResponse;
use App\Entity\Patient;
use App\model\PaginationModel;

class PaginationService
{
    public function getPaginatedItems(PaginationModel $paginationModel, $repository, string $entityName): array
    {
        $actualPage = $paginationModel->actualPage;
        $perPage = $paginationModel->perPage;
        $query = $paginationModel->query;
        $offset = $actualPage == 1 ? 0 : abs($perPage) * (abs($actualPage) - 1);
        $datas = $repository->findBy([], ['createdAt' => 'DESC'], $perPage, $offset);
        $totalPages = ceil(count($repository->findAll())/$perPage);
        $arrayData = [];
        foreach ($datas as $entity){
            $arrayData[] = $this->getEntityRequest($entityName, $entity);
        }
        if($query){
            $arrayData = $repository->searchByName($query);
        }

        return [
            'data' => $arrayData,
            'page' => !$query ? $actualPage : null,
            'perPage' => !$query ? $perPage : null,
            'totalPages' => !$query ? $totalPages : null
        ];
    }

    private function getEntityRequest(string $name, mixed $entity): mixed
    {
        switch ($name){
            case Patient::class:
                return new PatientResponse($entity);
                break;
            default:
                break;
        }
    }
}