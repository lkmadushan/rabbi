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
        $user = User::query()->firstOrNew(['onesignal_id' => $pushKey]);

        if ($user->exists) {
            throw RegisterUserException::userAlreadyExists();
        }

        $user->save();

        return $user;
    }
}
