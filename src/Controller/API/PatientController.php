<?php

namespace App\Controller\API;

use App\DTO\PatientRequest;
use App\Entity\Patient;
use App\model\PaginationModel;
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
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $patientRepository, Patient::class);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_get_one_patient', methods: 'GET')]
    public function getOne(int $id,PatientRepository $patientRepository): JsonResponse
    {
        $patient = $this->patientService->findOrFail($id);
        return $this->response($patient);
    }

    #[Route('/{id}', name: 'api_update_one_patient', methods: 'PUT')]
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

    #[Route('/{id}', name: 'api_delete_one_patient', methods: 'DELETE')]
    public function deleteOne(int $id,PatientRepository $patientRepository): JsonResponse
    {
        $this->patientService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/attr/sexes', name: 'api_patient_sexes', methods: 'GET')]
    public function sexes(): JsonResponse
    {
        return $this->response([Patient::MAN, Patient::WOMAN]);
    }

    #[Route('/attr/status', name: 'api_patient_status', methods: 'GET')]
    public function status(): JsonResponse
    {
        return $this->response(array_flip(Patient::STATUS));
    }

}