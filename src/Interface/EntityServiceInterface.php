<?php

namespace App\Interface;

interface EntityServiceInterface
{
    public function create($entityRequest, $loggedUser = null);
    public function findOrFail(int $id);
    public function update($entityRequest, $entity, $loggedUser = null);
    public function delete(int $id): void;

    public function setFields($entityRequest, $entity);
}