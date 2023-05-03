<?php

namespace App\Controller\API;

use App\DTO\AppointmentRequest;
use App\DTO\AppointmentResponse;
use App\Entity\Appointment;
use App\model\PaginationModel;
use App\Repository\AppointmentRepository;
use App\Service\AppointmentService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->response($appointmentResponse, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_appointment_all', methods: 'GET')]
    public function all(Request $request, AppointmentRepository $appointmentRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $appointmentRepository, Appointment::class);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'app_api_appointment_one', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $appointment = $this->appointmentService->findOrFail($id);
        return $this->response(new AppointmentResponse($appointment));
    }
    #[Route('/{id}', name: 'app_api_appointment_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $appointment = $this->appointmentService->findOrFail($id);
        $appointmentRequest = new AppointmentRequest($request);
        $validationErrors = $validator->validate($appointmentRequest);
        $this->checkValidationError($validationErrors);
        $appointmentResponse = $this->appointmentService->update($appointmentRequest, $appointment, $this->getUser());
        return $this->response(new AppointmentResponse($appointment));
    }

    #[Route('/{id}', name: 'app_api_appointment_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->appointmentService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}