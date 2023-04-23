<?php

namespace App\Controller\API;

use App\DTO\MedicalExamRequest;
use App\DTO\ParameterRequest;
use App\Service\MedicalExamService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/medical_exams')]
class MedicalExamController extends ApiController
{
    public function __construct(
        readonly private MedicalExamService $medicalExamService
    )
    {
    }

    #[Route('', name: 'api_medicalExam_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $medicalExamRequest = new MedicalExamRequest($request);
        $validationError = $validator->validate($medicalExamRequest);
        $this->checkValidationError($validationError);
        $medicalExam = $this->medicalExamService->create($medicalExamRequest, $this->getUser());
        return $this->response($medicalExam);
    }
}