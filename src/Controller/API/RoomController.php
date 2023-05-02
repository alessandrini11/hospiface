<?php

namespace App\Controller\API;

use App\DTO\RoomRequest;
use App\DTO\RoomResponse;
use App\Entity\Room;
use App\model\PaginationModel;
use App\Repository\RoomRepository;
use App\Service\PaginationService;
use App\Service\RoomService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/rooms')]
class RoomController extends ApiController
{
    public function __construct(
        readonly private RoomService $roomService,
        readonly private PaginationService $paginationService
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
        return $this->response($room->getData(), Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_room_all', methods: 'GET')]
    public function all(Request $request, RoomRepository $roomRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $roomRepository, Room::class);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_room_one', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $room = $this->roomService->findOrFail($id);
        return $this->response(new RoomResponse($room));
    }

    #[Route('/{id}', name: 'api_room_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $room = $this->roomService->findOrFail($id);
        $roomRequest = new RoomRequest($request);
        $validationErrors = $validator->validate($roomRequest);
        $this->checkValidationError($validationErrors);
        $updatedRoom = $this->roomService->update($roomRequest, $room, $this->getUser());
        return $this->response($updatedRoom->getData());
    }

    #[Route('/{id}', name: 'api_room_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->roomService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}