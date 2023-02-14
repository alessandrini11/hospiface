<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends ApiController
{
    #[Route('/api/test', name: 'app_test', methods: 'GET')]
    public function index(): JsonResponse
    {
        return $this->response(
            [
                'message' => 'it works'
            ]
        );
    }
}