<?php

namespace App\Service;

use App\DTO\ConsultationRequest;
use App\DTO\ConsultationResponse;
use App\Entity\Consultation;
use App\Entity\MedicalOrder;
use App\Entity\Parametre;
use App\Entity\Result;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\ConsultationRepository;
use App\Repository\MedicalOrderRepository;
use App\Repository\ParametreRepository;
use App\Repository\ResultRepository;

class ConsultationService implements EntityServiceInterface
{
    public function __construct(
        readonly private ConsultationRepository $consultationRepository,
        readonly private MedicalOrderRepository $medicalOrderRepository,
        readonly private ResultRepository $resultRepository,
        readonly private PatientService $patientService,
        readonly private PersonnelService $personnelService,
        readonly private ParameterService $parameterService
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): ConsultationResponse
    {
        $parameter = $this->parameterService->createOrUpdate($entityRequest);
        $parameter->setCreatedBy($loggedUser);
        $medicalOrder = new MedicalOrder();
        $medicalOrder->setCreatedBy($loggedUser);
        $result = new Result();
        $result
            ->setCreatedBy($loggedUser)
            ->setMedicalOrder($medicalOrder)
        ;
        $consultation = $this->setFields($entityRequest, new Consultation());
        $consultation
            ->setCreatedBy($loggedUser)
            ->setParameter($parameter)
            ->setResult($result);
        $this->medicalOrderRepository->save($medicalOrder);
        $this->resultRepository->save($result);
        $this->consultationRepository->save($consultation, true);
        return new ConsultationResponse($consultation);

    }

    public function update($entityRequest, $entity, $loggedUser = null): ConsultationResponse
    {

        $consultation = $this->setFields($entityRequest, $entity);
        $parameter = $consultation->getParameter();
        $this->parameterService->createOrUpdate($entityRequest, $parameter);
        $consultation
            ->setUpdatedBy($loggedUser);
        $this->consultationRepository->save($consultation, true);
        return new ConsultationResponse($consultation);
    }
    public function findOrFail(int $id): Consultation
    {
        $consultation = $this->consultationRepository->find($id);
        if(!$consultation) throw new NotFoundException('Consultation Not Found');
        return $consultation;
    }

    public function delete(int $id): void
    {
        $consultation = $this->findOrFail($id);
        $this->consultationRepository->remove($consultation, true);
    }

    public function setFields($entityRequest, $entity): ?Consultation
    {
        if (!$entityRequest instanceof ConsultationRequest && !$entity instanceof Consultation) return null;
        if($entityRequest->doctor){
            $doctor = $this->personnelService->findOrFail($entityRequest->doctor);
            $entity->setDoctor($doctor);
        }
        if($entityRequest->patient){
            $patient = $this->patientService->findOrFail($entityRequest->patient);
            $entity->setPatient($patient);
        }
        if($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }

    public function getConsultationEachMonth(): array
    {
        $consultations = $this->consultationRepository->getConsultationEachMonth();
        return $this->sortArray($consultations);
    }
    public function getConsultationTargetYear(string $targetYear): array
    {
        $consultations = $this->consultationRepository->getConsultationByYears($targetYear);
        return $this->sortArray($consultations);
    }

    private function sortArray(array $consultations): array
    {
        $groupedMonth = [];
        foreach ($consultations as $consultation ) {
            $month = $consultation->getCreatedAt()->format('F');
            $groupedMonth[$month][] = $consultation;
        }
        $labelArray = [];
        $dataArray = [];
        foreach ($groupedMonth as $month => $consultations) {
            $labelArray[] = $month;
            $dataArray[] = count($consultations);
        }
        return [
            'labels' => $labelArray,
            'datas' => $dataArray,
            'name' => 'consultations '
        ];
    }
}