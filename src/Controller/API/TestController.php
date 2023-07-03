<?php

namespace App\Controller\API;

use App\Entity\Appointment;
use App\Entity\Consultation;
use App\Entity\Drug;
use App\Entity\MedicalOrder;
use App\Entity\Parametre;
use App\Entity\Patient;
use App\Entity\Personnel;
use App\Entity\Result;
use App\Entity\Room;
use App\Entity\Speciality;
use App\Repository\PatientRepository;
use App\Repository\PersonnelRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends ApiController
{
    private $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr');
    }

    #[Route('/api/test', name: 'app_test', methods: 'GET')]
    public function index(
        EntityManagerInterface $entityManager,
        PersonnelRepository $personnelRepository,
        PatientRepository $patientRepository
    ): JsonResponse
    {
        $patients = $patientRepository->findBy(["status" => !Patient::DEATH]);
        $doctors = $personnelRepository->findBy(["subType" => Personnel::DOCTOR]);
        for ($i = 9; $i < 30; $i++){
            $room = new Room();
            $room->setNumber($i)
                ->setBeds($this->faker->randomNumber(1, 10))
            ;
            $entityManager->persist($room);
        }
        $entityManager->flush();


        return $this->response(
            [
                'message' => 'it works'
            ]
        );
    }
}