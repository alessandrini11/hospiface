<?php

namespace App\Service;

use App\DTO\PatientRequest;
use App\DTO\PatientResponse;
use App\Entity\Patient;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Interface\EntityInterface;
use App\Interface\EntityServiceInterface;
use App\Repository\PatientRepository;

class PatientService implements EntityServiceInterface
{

    public function __construct(
        readonly private PatientRepository $patientRepository
    ){

    }
    public function create($entityRequest, $loggedUser = null): PatientResponse
    {
        $isPatientExist = $this->patientRepository->findBy(['email' => $entityRequest->email]);
        if ($isPatientExist) throw new BadRequestException('Patient with email already exist');
        $patient = $this->setFields($entityRequest, new Patient());
        $patient->setCreatedBy($loggedUser);
        $this->patientRepository->save($patient, true);
        return new PatientResponse($patient);
    }

    public function findOrFail(int $id): Patient
    {
        $patient = $this->patientRepository->find($id);
        if(!$patient) throw new NotFoundException('Patient Not Found');
        return $patient;
    }

    public function update($entityRequest, $entity, $loggedUser = null): PatientResponse
    {
        $patient = $this->setFields($entityRequest, $entity);
        $patient->setUpdatedBy($loggedUser);
        $this->patientRepository->save($patient, true);
        return new PatientResponse($patient);
    }

    public function delete(int $id): void
    {
        $patient = $this->findOrFail($id);
        $this->patientRepository->remove($patient, true);
    }

    public function setFields($entityRequest, $entity): null | Patient
    {
        if (!$entityRequest instanceof PatientRequest && !$entity instanceof Patient) return null;
        if($entityRequest->firstName){
            $entity->setFirstname($entityRequest->firstName);
        }
        if($entityRequest->lastName){
            $entity->setLastname($entityRequest->lastName);
        }
        if($entityRequest->email){
            $entity->setEmail($entityRequest->email);
        }
        if($entityRequest->sex){
            $entity->setSex($entityRequest->sex);
        }
        if($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        if($entityRequest->phoneNumber){
            $entity->setPhonenumber($entityRequest->phoneNumber);
        }
        if($entityRequest->emergencyPerson){
            $entity->setEmergencyPersonne($entityRequest->emergencyPerson);
        }
        if($entityRequest->emergencyContact){
            $entity->setEmergencyContact($entityRequest->emergencyContact);
        }
        if($entityRequest->birthDate){
            try {
                $entity->setBirthDate($entityRequest->birthDate);
            } catch (\Exception $e){
                throw new BadRequestException();
            }
        }
        if($entityRequest->bloodGroup){
            $entity->setBloodGroup($entityRequest->bloodGroup);
        }
        return $entity;
    }
    public function getPatientEachMonth(): array
    {
        $patients = $this->patientRepository->getPatientEachMonth();
        return $this->sortArray($patients);
    }
    public function getPatientTargetYear(string $targetYear): array
    {
        $patients = $this->patientRepository->getPatientByYears($targetYear);
        return $this->sortArray($patients);
    }

    private function sortArray(array $entityArray): array
    {
        $groupedMonth = [];
        foreach ($entityArray as $entity ) {
            $month = $entity->getCreatedAt()->format('F');
            $groupedMonth[$month][] = $entity;
        }
        $labelArray = [];
        $dataArray = [];
        foreach ($groupedMonth as $month => $entities) {
            $labelArray[] = $month;
            $dataArray[] = count($entities);
        }
        return [
            'labels' => $labelArray,
            'datas' => $dataArray,
            'name' => 'patients '
        ];
    }
}