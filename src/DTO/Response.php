<?php

namespace App\DTO;

use App\Exceptions\ApiException;

class Response
{
    public mixed $data;
    public ?bool $success;
    public ?ApiException $error;

    public function __construct(mixed $data, bool $success, ?ApiException $error)
    {
        $this->data = $data;
        $this->success = $success;
        $this->error = $error;
    }
}