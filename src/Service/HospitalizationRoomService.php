<?php

namespace App\Service;

use App\Entity\HospitalizationRoom;
use App\Entity\Hospitilization;
use App\Entity\Room;
use App\Repository\HospitalizationRoomRepository;

class HospitalizationRoomService
{
    public function __construct(
        readonly private HospitalizationRoomRepository $hospitalizationRoomRepository
    )
    {
    }
    public function createOrUpdate(Hospitilization $hospitalization, Room $room): HospitalizationRoom
    {
        $hospitalRoom = null;
        if(!$hospitalization->getHospitalizationRoom()){
            $hospitalRoom = new HospitalizationRoom();
        }else {
            $hospitalRoom = $hospitalization->getHospitalizationRoom();
        }
        $hospitalRoom->setRoom($room);
        $this->hospitalizationRoomRepository->save($hospitalRoom);
        return $hospitalRoom;
    }
}