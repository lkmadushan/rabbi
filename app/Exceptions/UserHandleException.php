<?php

namespace App\Exceptions;

class UserHandleException extends \Exception
{
    public static function noUserRoleAssignment(): UserHandleException
    {
        return new self('No user ID found');
    }
}
