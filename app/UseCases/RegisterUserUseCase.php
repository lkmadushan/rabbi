<?php

namespace App\UseCases;

use App\Models\User;
use App\Exceptions\RegisterUserException;

class RegisterUserUseCase
{
    /**
     * @throws RegisterUserException
     */
    public function execute(string $pushKey): User
    {
        if (empty($pushKey)) {
            throw RegisterUserException::noPushNotificationKeyProvided();
        }

        /** @var User $user */
        $user = User::query()->firstOrNew(['onesignal_sub_id' => $pushKey]);

        $user->save();

        return $user;
    }
}
