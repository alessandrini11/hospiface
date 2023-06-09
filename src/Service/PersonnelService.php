<?php

namespace App\Service;

use App\DTO\PersonnelRequest;
use App\DTO\PersonnelResponse;
use App\Entity\Personnel;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\PersonnelRepository;

class PersonnelService implements EntityServiceInterface
{
    public function __construct(
        readonly private PersonnelRepository $personnelRepository,
        readonly private SpecialityService $specialityService
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): PersonnelResponse
    {
        $isExist = $this->personnelRepository->findBy(['email' => $entityRequest->email]);
        if($isExist) throw new BadRequestException('Personnel With Email Already Exist');
        $personnel = $this->setFields($entityRequest, new Personnel());
        $personnel->setCreatedBy($loggedUser);
        $this->personnelRepository->save($personnel, true);
        return new PersonnelResponse($personnel);
    }

    public function findOrFail(int $id): Personnel
    {
        $personnel = $this->personnelRepository->find($id);
        if(!$personnel) throw new NotFoundException('Personnel Not Found');
        return $personnel;
    }

    public function update($entityRequest, $entity, $loggedUser = null): PersonnelResponse
    {
        $personnel = $this->setFields($entityRequest, $entity);
        $personnel->setUpdatedBy($loggedUser);
        $this->personnelRepository->save($personnel, true);
        return new PersonnelResponse($personnel);
    }

    public function delete(int $id): void
    {
        $personnel = $this->findOrFail($id);
        // $this->personnelRepository->remove($personnel, true);
        $personnel->setStatus(Personnel::STATUS_DELETED);
        $this->personnelRepository->save($personnel, true);
    }

    public function setFields($entityRequest, $entity): ?Personnel
    {
        if (!$entityRequest instanceof PersonnelRequest && !$entity instanceof Personnel) return null;
        if ($entityRequest->firstName){
            $entity->setFirstname($entityRequest->firstName);
        }
        if ($entityRequest->lastName){
            $entity->setLastname($entityRequest->lastName);
        }
        if ($entityRequest->email){
            $entity->setEmail($entityRequest->email);
        }
        if ($entityRequest->phoneNumber){
            $entity->setPhonenumber($entityRequest->phoneNumber);
        }
        if ($entityRequest->sex){
            $entity->setSex($entityRequest->sex);
        }
        if ($entityRequest->bloodGroup){
            $entity->setBloodGroup($entityRequest->bloodGroup);
        }
        if ($entityRequest->birthDate){
            $entity->setBirthDate($entityRequest->birthDate);
        }
        if ($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if ($entityRequest->subType){
            $entity->setSubType($entityRequest->subType);
        }
        if ($entityRequest->speciality){
            $speciality = $this->specialityService->findOrFail($entityRequest->speciality);
            $entity->setSpeciality($speciality);
        }
        if ($entityRequest->title){
            $entity->setTitle($entityRequest->title);
        }
        if ($entityRequest->positionHeld){
            $entity->setPositionHeld($entityRequest->positionHeld);
        }
        if ($entityRequest->status !== null){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }
}