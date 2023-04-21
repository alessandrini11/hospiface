<?php

namespace App\Controller\API;

use App\DTO\PatientRequest;
use App\Repository\PatientRepository;
use App\Service\PatientService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/patients')]
class PatientController extends ApiController
{
    public function __construct(
        readonly private PatientService $patientService
    )
    {
    }

    #[Route('', name: 'api_patient_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $patientRequest = new PatientRequest($request);
        $validationError = $validator->validate($patientRequest);
        $this->checkValidationError($validationError);
        $patientResponse = $this->patientService->create($patientRequest, $this->getUser());
        return $this->response($patientResponse);
    }

    #[Route('', name: 'api_get_all_patients', methods: 'GET')]
    public function getAll(PatientRepository $patientRepository): JsonResponse
    {
        $patients = $patientRepository->findAll();
        return $this->response($patients);
    }
}