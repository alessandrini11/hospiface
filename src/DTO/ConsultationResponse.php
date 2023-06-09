<?php

namespace App\DTO;

use App\Entity\Consultation;

class ConsultationResponse
{
    public ?int $id;
    public ?string $type;
    public ?int $status;
    public ?array $doctor;
    public ?array $patient;
    public ?array $result;
    public ?array $parameter;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Consultation $consultation)
    {
        $this->id = $consultation->getId();
        $this->type = $consultation->getType();
        $this->status = (int) $consultation->getStatus();
        $this->doctor = $consultation->getDoctor()?->getData();
        $this->patient = $consultation->getPatient()?->getData();
        $this->parameter = $consultation->getParameter()?->getData();
        $this->created_by = $consultation->getCreatedBy()?->getData();
        $this->updated_by = $consultation->getUpdatedBy()?->getData();
        $this->created_at = $consultation->getCreatedAt();
        $this->updated_at = $consultation->getUpdatedAt();
        $result =  $consultation->getResult()?->getData();
        $medicalOrder = $consultation->getResult()?->getMedicalOrder();
        $drugs = $medicalOrder->getDrugs() ? $medicalOrder->getDrugs() : [];
        $medicalExamConsultations = $consultation->getResult() ? $consultation->getResult()->getMedicalExam() : [];
        $drugArray = [];
        $examArray = [];
        foreach ($drugs as $drug){
            $drugArray[] = $drug->getData();
        }
        foreach ($medicalExamConsultations as $exam){
            $examArray[] = $exam->getData();
        }
        $result["medical_order"] = ['id' => $medicalOrder->getId(), 'drugs' => $drugArray];
        $result["medical_exams"] = $examArray;
        $this->result = $result;
    }
}