<?php

namespace App\Controller\API;

use App\DTO\PatientRequest;
use App\Repository\PatientRepository;
use App\Service\PaginationService;
use App\Service\PatientService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/patients')]
class PatientController extends ApiController
{
    public function __construct(
        readonly private PatientService $patientService,
        readonly private PaginationService $paginationService
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
        return $this->response($patientResponse, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_get_all_patients', methods: 'GET')]
    public function getAll(Request $request, PatientRepository $patientRepository): JsonResponse
    {
        $array = $this->paginationService->getPaginatedItems(
            (int) $request->query->get('perPage', 1),
            (int) $request->query->get('actualPage', 1),
            $patientRepository
        );
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_get_one_patients', methods: 'GET')]
    public function getOne(int $id,PatientRepository $patientRepository): JsonResponse
    {
        $patient = $this->patientService->findOrFail($id);
        return $this->response($patient);
    }

    #[Route('/{id}', name: 'api_update_one_patients', methods: 'PUT')]
    public function updateOne(
        int $id,
        Request $request,
        ValidatorInterface $validator,
        PatientRepository $patientRepository
    ): JsonResponse
    {
        $patient = $this->patientService->findOrFail($id);
        $patientRequest = new PatientRequest($request);
        $validationErrors = $validator->validate($patientRequest);
        $this->checkValidationError($validationErrors);
        $patientResponse = $this->patientService->update($patientRequest, $patient, $this->getUser());
        return $this->response($patientResponse);
    }

    #[Route('/{id}', name: 'api_delete_one_patients', methods: 'DELETE')]
    public function deleteOne(int $id,PatientRepository $patientRepository): JsonResponse
    {
        $this->patientService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }

}