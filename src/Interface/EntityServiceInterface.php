<?php

namespace App\Interface;

interface EntityServiceInterface extends BasicEntityServiceInterface
{
    public function create($entityRequest, $loggedUser = null);
    public function delete(int $id): void;
}