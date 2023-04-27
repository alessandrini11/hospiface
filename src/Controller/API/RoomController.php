<?php

namespace App\Controller\API;

use App\DTO\RoomRequest;
use App\Service\RoomService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/rooms')]
class RoomController extends ApiController
{
    public function __construct(
        readonly private RoomService $roomService
    )
    {
    }

    #[Route('', name: 'api_room_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $roomRequest = new RoomRequest($request);
        $validationErrors = $validator->validate($roomRequest);
        $this->checkValidationError($validationErrors);
        $room = $this->roomService->create($roomRequest, $this->getUser());
        return $this->response($room);
    }

    #[Route('', name: 'api_room_all', methods: 'GET')]
    public function all(): JsonResponse
    {
        $this->response();
    }

    #[Route('/{id}', name: 'api_room_one', methods: 'GET')]
    public function one(): JsonResponse
    {
        $this->response();
    }

    #[Route('/{id}', name: 'api_room_update', methods: 'PUT')]
    public function update(): JsonResponse
    {
        $this->response();
    }

    #[Route('/{id}', name: 'api_room_delete', methods: 'DELETE')]
    public function delete(): JsonResponse
    {
        $this->response();
    }
}