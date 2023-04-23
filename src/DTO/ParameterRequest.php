<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class ParameterRequest
{
    #[Assert\Type('float')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 4)]
    public ?float $temperature;

    #[Assert\Type(type: 'float')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 5)]
    public ?float $bloodPressure;

    #[Assert\Type(type: 'float')]
    #[Assert\NotBlank(allowNull: true)]
    public ?float $weight;

    #[Assert\Type(type: 'float')]
    #[Assert\NotBlank(allowNull: true)]
    public ?float $height;

    public function __construct(Request $request)
    {
        $this->temperature = $request->get('temperature');
        $this->bloodPressure = $request->get('bloodPressure');
        $this->weight = $request->get('weight');
        $this->height = $request->get('height');
    }
}