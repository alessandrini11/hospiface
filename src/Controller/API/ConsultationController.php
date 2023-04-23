<?php

namespace App\Controller\API;

use App\DTO\ConsultationRequest;
use App\Service\ConsultationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/consultations')]
class ConsultationController extends ApiController
{
    public function __construct(
        readonly private ConsultationService $consultationService
    )
    {
    }

    #[Route('', name: 'api_consultation_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $consultationRequest = new ConsultationRequest($request);
        $validationError = $validator->validate($consultationRequest);
        $this->checkValidationError($validationError);
        $consultation = $this->consultationService->create($consultationRequest, $this->getUser());
        return $this->response($consultation, Response::HTTP_CREATED);
    }
}