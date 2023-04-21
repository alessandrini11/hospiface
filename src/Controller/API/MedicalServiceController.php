<?php

namespace App\Controller\API;

use App\DTO\MedicalServiceRequest;
use App\Service\MedicalServiceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/medical_services')]
class MedicalServiceController extends ApiController
{
    public function __construct(
        readonly private MedicalServiceService $medicalServiceService
    )
    {
    }

    #[Route('', name: 'api_medical_service_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $medicalServiceRequest = new MedicalServiceRequest($request);
        $validationErrors = $validator->validate($medicalServiceRequest);
        $this->checkValidationError($validationErrors);
        $medicalService = $this->medicalServiceService->create($medicalServiceRequest, $this->getUser());
        return $this->response($medicalService);
    }
}