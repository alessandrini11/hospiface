<?php

namespace App\Service;

use App\DTO\ConsultationResponse;
use App\DTO\DrugResponse;
use App\DTO\MedicalServiceResponse;
use App\DTO\PatientRequest;
use App\DTO\PatientResponse;
use App\DTO\PersonnelMedicalServiceResponse;
use App\DTO\PersonnelResponse;
use App\DTO\SpecialityResponse;
use App\Entity\Consultation;
use App\Entity\Drug;
use App\Entity\Patient;
use App\Entity\Personnel;
use App\Entity\PersonnelService;
use App\Entity\Service;
use App\Entity\Speciality;
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
            case Service::class:
                return new MedicalServiceResponse($entity);
                break;
            case Speciality::class:
                return new SpecialityResponse($entity);
                break;
            case Personnel::class:
                return new PersonnelResponse($entity);
                break;
            case Consultation::class:
                return new ConsultationResponse($entity);
                break;
            case PersonnelService::class:
                return new PersonnelMedicalServiceResponse($entity);
                break;
            case Drug::class:
                return new DrugResponse($entity);
                break;
            default:
                break;
        }
    }
}