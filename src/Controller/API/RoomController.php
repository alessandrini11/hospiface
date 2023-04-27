<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rooms')]
class RoomController extends ApiController
{
    #[Route('', name: 'api_room_create', methods: 'POST')]
    public function create(): JsonResponse
    {
        $this->response();
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