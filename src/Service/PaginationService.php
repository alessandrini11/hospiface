<?php

namespace App\Service;

use App\DTO\AppointmentResponse;
use App\DTO\ConsultationResponse;
use App\DTO\DrugResponse;
use App\DTO\GardeResponse;
use App\DTO\HospitalizationResponse;
use App\DTO\MedicalServiceResponse;
use App\DTO\PatientRequest;
use App\DTO\PatientResponse;
use App\DTO\PersonnelMedicalServiceResponse;
use App\DTO\PersonnelResponse;
use App\DTO\RoomResponse;
use App\DTO\SpecialityResponse;
use App\DTO\UserResponse;
use App\Entity\Appointment;
use App\Entity\Consultation;
use App\Entity\Drug;
use App\Entity\Garde;
use App\Entity\Hospitilization;
use App\Entity\Patient;
use App\Entity\Personnel;
use App\Entity\PersonnelService;
use App\Entity\Room;
use App\Entity\Service;
use App\Entity\Speciality;
use App\Entity\User;
use App\model\PaginationModel;

class PaginationService
{
    public function getPaginatedItems(PaginationModel $paginationModel, $repository, string $entityName): array
    {
        $actualPage = $paginationModel->actualPage;
        $perPage = $paginationModel->perPage;
        $query = $paginationModel->query;
        $offset = $actualPage == 1 ? 0 : abs($perPage) * (abs($actualPage) - 1);
        $datas = $repository->findBy([], ['createdAt' => 'DESC'], $perPage, abs($offset));
        $totalPages = ceil(count($repository->findAll())/$perPage);
        $arrayData = [];
        if(!$query){
            foreach ($datas as $entity){
                $arrayData[] = $this->getEntityRequest($entityName, $entity);
            }
        }else {
            $searchData = $repository->searchByName($query);
            foreach ($searchData as $entity){
                $arrayData[] = $this->getEntityRequest($entityName, $entity);
            }
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
            case Garde::class:
                return new GardeResponse($entity);
                break;
            case Hospitilization::class:
                return new HospitalizationResponse($entity);
                break;
            case Room::class:
                return new RoomResponse($entity);
                break;
            case Appointment::class:
                return new AppointmentResponse($entity);
            case User::class:
                return new UserResponse($entity);
            default:
                break;
        }
    }
}