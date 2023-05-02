<?php

namespace App\DTO;

use App\Entity\Room;

class RoomResponse
{
    public ?int $id;
    public ?int $number;
    public ?int $beds;
    public ?array $hospitalizations;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;

    public function __construct(Room $room)
    {
        $this->id = $room->getId();
        $this->number = $room->getNumber();
        $this->beds = $room->getBeds();
        $this->created_by = $room->getCreatedBy()?->getData();
        $this->updated_by = $room->getUpdatedBy()?->getData();
        $this->created_at = $room->getCreatedAt();
        $this->updated_at = $room->getUpdatedAt();
        $hospitalizations = [];
        foreach ($room->getHospitalizationRooms() as $hospitalizationRoom){
            $hospitalizations[] = $hospitalizationRoom->getHospitilization()->getData();
        }
        $this->hospitalizations = $hospitalizations;
    }
}