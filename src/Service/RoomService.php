<?php

namespace App\Service;

use App\DTO\RoomRequest;
use App\Entity\Hospitilization;
use App\Entity\Room;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\RoomRepository;

class RoomService implements EntityServiceInterface
{
    public function __construct(
        readonly private RoomRepository $roomRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Room
    {
        $room = $this->setFields($entityRequest, new Room());
        $room->setCreatedBy($loggedUser);
        $this->roomRepository->save($room, true);
        return $room;
    }
    public function update($entityRequest, $entity, $loggedUser = null): Room
    {
        $room = $this->setFields($entityRequest, $entity);
        $room->setUpdatedBy($loggedUser);
        $this->roomRepository->save($room, true);
        return $room;
    }
    public function findOrFail(int $id): Room
    {
        $room = $this->roomRepository->find($id);
        if(!$room) throw new NotFoundException('Room Not Found');
        return $room;
    }
    public function delete(int $id): void
    {
        $room = $this->findOrFail($id);
        $this->roomRepository->remove($room, true);
    }
    public function setFields($entityRequest, $entity): ?Room
    {
        if(!$entityRequest instanceof RoomRequest && !$entity instanceof Room) return null;
        if($entityRequest->beds){
            $entity->setBeds($entityRequest->beds);
        }
        if($entityRequest->number){
            $entity->setNumber($entityRequest->number);
        }
        return $entity;
    }

    public function isFull(Room $room): void
    {
        $hospitalizationRooms = $room->getHospitalizationRooms();
        $hospitalization = [];
        foreach ($hospitalizationRooms as $item){
            if ($item->getHospitilization()->getStatus() === Hospitilization::STARTED){
                $hospitalization[] = $item->getHospitilization();
            }
        }
        if(count($hospitalization) >= $room->getBeds()){
            throw new BadRequestException("The Room Can Not Contain More Than {$room->getBeds()} Patients" );
        }
    }
}