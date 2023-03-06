<?php

namespace App\Exceptions;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserStatusException extends ApiException
{
    public function __construct(
        int $userStatus,
        string $message = 'User status does not allow the action to be performed'
        )
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
        switch ($userStatus) {
            case User::STATUS_DISABLED:
                $this->message = 'User has not been verified';
                break;
            case User::STATUS_ENABLED:
                $this->message = 'User has been verified';
                break;
            case User::STATUS_DELETED:
                $this->message = 'User has been deleted';
            default:
                break;
        }
    }
}