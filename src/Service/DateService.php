<?php

namespace App\Service;

use App\Exceptions\BadRequestException;

class DateService
{
    public function compareDates($endDate, $startDate, $message = 'The Start Date Must Be Smaller than End Date'): void
    {
        if($endDate < $startDate){
            throw new BadRequestException($message);
        }
    }
}