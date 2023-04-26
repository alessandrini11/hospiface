<?php

namespace App\Service;

use App\Exceptions\BadRequestException;

class DateService
{
    public function compareDates($endDate, $startDate): void
    {
        if($endDate <= $startDate){
            throw new BadRequestException('The Start Date Must Be Smaller than End Date');
        }
    }
}