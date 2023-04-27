<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class RoomRequest
{
    public ?string $number;
    public ?int $beds;
    public function __construct(Request $request)
    {
        $this->number = $request->get('number');
        $this->beds = (int) $request->get('beds');
    }
}