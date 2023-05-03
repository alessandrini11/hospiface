<?php

namespace App\Controller\API;

use App\DTO\AppointmentRequest;
use App\Entity\Appointment;
use App\model\PaginationModel;
use App\Repository\AppointmentRepository;
use App\Service\AppointmentService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/appointments')]
class AppointmentController extends ApiController
{
    public function __construct(
        readonly private AppointmentService $appointmentService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_appointment_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $appointmentRequest = new AppointmentRequest($request);
        $validationErrors = $validator->validate($appointmentRequest);
        $this->checkValidationError($validationErrors);
        $appointmentResponse = $this->appointmentService->create($appointmentRequest, $this->getUser());
        return $this->response($appointmentResponse);
    }

    #[Route('', name: 'api_appointment_all', methods: 'GET')]
    public function all(Request $request, AppointmentRepository $appointmentRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $appointmentRepository, Appointment::class);
        return $this->response($array);
    }
}