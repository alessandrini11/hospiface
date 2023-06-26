<?php

namespace App\Controller\API;

use App\Repository\GardeRepository;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/generate_pdf/test')]
class PDFController extends ApiController
{
    #[Route('', name: 'app_api_pdf_guards', methods: 'GET')]
    public function guards(GardeRepository $gardeRepository): Response
    {
        $gard = $gardeRepository->find(9);
        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4');

// Render the HTML as PDF
        $dompdf->render();

        return new Response (
            $dompdf->stream(),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
//        $dompdf->stream();
    }

    private function imageToBase64($path): string {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}