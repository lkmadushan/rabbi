<?php

namespace App\UseCases;

use App\Exceptions\RegisterUserException;
use App\Models\User;
use function PHPUnit\Framework\isEmpty;

class RegisterUserUseCase
{
    /**
     * @throws RegisterUserException
     */
    public function execute(string $userKey): User
    {
        $response = [];
        if (empty($userKey)) {
            throw RegisterUserException::noUserProvided();
        }

        $user = User::firstOrNew(
            ['onesignal_sub_id' =>  $userKey]
        );
        $user->save();

        return $user;
    }
}
