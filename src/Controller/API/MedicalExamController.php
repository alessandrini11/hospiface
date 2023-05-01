<?php

namespace App\Controller\API;

use App\DTO\MedicalExamRequest;
use App\DTO\ParameterRequest;
use App\Service\MedicalExamService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->response($medicalExam->getData(), Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_medicalexam_getOne', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $medicalExam = $this->medicalExamService->findOrFail($id);
        return $this->response($medicalExam->getData());
    }
    #[Route('/{id}', name: 'api_medicalExam_updateOne', methods: 'PUT')]
    public function updateOne(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $medicalExam = $this->medicalExamService->findOrFail($id);
        $medicalExamRequest = new MedicalExamRequest($request);
        $validationError = $validator->validate($medicalExamRequest);
        $this->checkValidationError($validationError);
        $updatedMedicalExam = $this->medicalExamService->update($medicalExamRequest, $medicalExam, $this->getUser());
        return $this->response($updatedMedicalExam->getData());
    }
    #[Route('/{id}', name: 'api_medicalexam_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->medicalExamService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}