<?php

namespace App\Interface;

interface EntityInterface
{
    /**
     * @return array
     * get data and send to user
     */
    public function getData(): array;

}