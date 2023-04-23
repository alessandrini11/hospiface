<?php

namespace App\Interface;

interface BasicEntityServiceInterface
{
    public function update($entityRequest, $entity, $loggedUser = null);
    public function findOrFail(int $id);
    public function setFields($entityRequest, $entity);
}