<?php

namespace App\Exceptions;

class RegisterUserException extends \Exception
{
    public static function noUserProvided(): RegisterUserException
    {
        return new self('No user ID found');
    }
}
