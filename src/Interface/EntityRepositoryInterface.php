<?php

namespace App\Interface;

interface EntityRepositoryInterface
{
    public function searchByName(string $query);
}