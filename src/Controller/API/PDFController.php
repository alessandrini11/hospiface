<?php

namespace App\Controller\API;

use App\Repository\GardeRepository;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/generate_pdf')]
class PDFController extends ApiController
{
    #[Route('/garde/{id}', name: 'app_api_pdf_guards', methods: 'GET')]
    public function guards(int $id, GardeRepository $gardeRepository): Response
    {
        $garde = $gardeRepository->find($id);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $dompdf->setOptions($options);
        $html = $this->render('pdfgenerator/gardes.html.twig', [
            'garde' => $garde
        ]);
        $html .= '<link type="text/css" href="https://localhost:8000/assets/style.css" rel="stylesheet" />';
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        return new Response (
            $dompdf->stream("garde.pdf"),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64($path): string {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}