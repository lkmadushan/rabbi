<?php

namespace App\Exceptions;

use Exception;

class RegisterUserException extends Exception
{
    public static function noPushNotificationKeyProvided(): RegisterUserException
    {
        return new self('No push notification key provided');
    }
}
