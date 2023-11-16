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
    public function execute(string $userId): User
    {
        $response = [];
        if (empty($userId)) {
            throw RegisterUserException::noUserProvided();
        }

        $user = User::firstOrNew(
            ['onesignal_sub_id' =>  $userId]
        );
        $user->save();

        return $user;
    }
}
