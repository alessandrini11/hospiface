<?php

namespace App\Controller\API;

use App\Entity\Consultation;
use App\Entity\Patient;
use App\Entity\Personnel;
use App\Repository\ConsultationRepository;
use App\Repository\HospitilizationRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonnelRepository;
use App\Repository\RoomRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use App\Service\ConsultationService;
use App\Service\PatientService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/stats', methods: 'GET')]
class StatsController extends ApiController
{
    public function __construct(
        readonly private ConsultationService $consultationService,
        readonly private PatientService $patientService
    )
    {
    }

    #[Route('/patients', name: 'app_api_stats_patients')]
    public function patients(PatientRepository $patientRepository): JsonResponse
    {
        $patients = $patientRepository->findAll();
        $array = [];
        foreach ($patients as $patient){
            $array[] = $patient->getData();
        }
        return $this->response($array);
    }
    #[Route('/consultations', name: 'app_api_stats_consultations')]
    public function consultations(ConsultationRepository $consultationRepository): JsonResponse
    {
        $consultations = $consultationRepository->findAll();
        $array = [];
        foreach ($consultations as $consultation){
            $array[] = $consultation->getData();
        }
        return $this->response($array);
    }

    #[Route('/personnel', name: 'app_api_stats_personnel')]
    public function personnel(PersonnelRepository $personnelRepository): JsonResponse
    {
        $personnels = $personnelRepository->findAll();
        $array = [];
        foreach ($personnels as $personnel){
            $array[] = $personnel->getData();
        }
        return $this->response($array);
    }
    #[Route('/services', name: 'app_api_stats_services')]
    public function services(ServiceRepository $serviceRepository): JsonResponse
    {
        $services = $serviceRepository->findAll();
        $array = [];
        foreach ($services as $service){
            $array[] = $service->getData();
        }
        return $this->response($array);
    }
    #[Route('/users', name: 'app_api_stats_users')]
    public function users(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $array = [];
        foreach ($users as $user){
            $array[] = $user->getData();
        }
        return $this->response($array);
    }
    #[Route('/hospitalizations', name: 'app_api_stats_hospitalizations')]
    public function hospitalizations(HospitilizationRepository $hospitilizationRepository): JsonResponse
    {
        $hospitilizations = $hospitilizationRepository->findAll();
        $array = [];
        foreach ($hospitilizations as $hospitalization){
            $array[] = $hospitalization->getData();
        }
        return $this->response($array);
    }
    #[Route('/rooms', name: 'app_api_stats_rooms')]
    public function rooms(RoomRepository $roomRepository): JsonResponse
    {
        $rooms = $roomRepository->findAll();
        $array = [];
        foreach ($rooms as $room){
            $array[] = $room->getData();
        }
        return $this->response($array);
    }
    #[Route('/consultations_chart', name: 'app_api_stats_consultations_chart')]
    public function consultations_chart(Request $request, ConsultationService $consultationService): JsonResponse
    {
        $year = $request->query->get('year');
        $array = $this->consultationService->getConsultationEachMonth();
        if($year){
            $array = $this->consultationService->getConsultationTargetYear($year);
        }
        return $this->response($array);
    }

    #[Route('/patients_chart', name: 'app_api_stats_patients_chart')]
    public function patients_chart(Request $request, PatientRepository $patientRepository): JsonResponse
    {
        $year = $request->query->get('year');
        $array = $this->patientService->getPatientEachMonth();
        if($year){
            $array = $this->patientService->getPatientTargetYear($year);
        }
        return $this->response($array);
    }
    #[Route('/personnel_sex_chart', name: 'app_api_stats_personnel_sex_chart')]
    public function personnel_sex_chart( PersonnelRepository $personnelRepository): JsonResponse
    {
        $women = $personnelRepository->findBy(['sex' => Personnel::WOMAN]);
        $man = $personnelRepository->findBy(['sex' => Personnel::MAN]);

        $array = [
            "labels" => ["hommes", "femmes"],
            "datas" => [count($man), count($women)],
            "name" => "personnel"
        ];
        return $this->response($array);
    }
    #[Route('/patients_sex_chart', name: 'app_api_stats_patient_sex_chart')]
    public function patient_sex_chart( PatientRepository $patientRepository): JsonResponse
    {
        $women = $patientRepository->findBy(['sex' => Patient::WOMAN]);
        $man = $patientRepository->findBy(['sex' => Patient::MAN]);

        $array = [
            "labels" => ["hommes", "femmes"],
            "datas" => [count($man), count($women)],
            "name" => "patients"
        ];
        return $this->response($array);
    }
    #[Route('/patients_age_chart', name: 'app_api_stats_patient_age_chart')]
    public function patient_age_chart( PatientRepository $patientRepository): JsonResponse
    {
        $patients = $patientRepository->findAll();
        $u5 = [];
        $u10 = [];
        $u20 = [];
        $u35 = [];
        $u50 = [];
        $u80 = [];
        $o80 = [];
        foreach ($patients as $patient){
            $diff = $patient->getBirthDate()->diff(new \DateTime())->y;
            switch ($diff){
                case $diff <= 5:
                    $u5[] = $patient;
                    break;
                case $diff > 5 && $diff <= 10:
                    $u10[] = $patient;
                    break;
                case $diff > 10 && $diff <= 20:
                    $u20[] = $patient;
                    break;
                case $diff > 20 && $diff <= 35:
                    $u35[] = $patient;
                    break;
                case $diff > 35 && $diff <= 50:
                    $u50[] = $patient;
                    break;
                case $diff > 50 && $diff <= 80:
                    $u80[] = $patient;
                    break;
                case $diff > 80:
                    $o80[] = $patient;
                    break;
                default:
                    break;
            }
        }
        $array = [
            "labels" => ["U5", "U10", "U20", "U35", "U50", "U80", "Ov80"],
            "datas" => [count($u5), count($u10), count($u20), count($u35), count($u50), count($u80), count($o80)],
            "name" => "age des patients"
        ];
        return $this->response($array);
    }
}