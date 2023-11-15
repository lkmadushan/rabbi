<?php

namespace App\UseCases;

use App\Exceptions\UserHandleException;
use App\Models\User;
use function PHPUnit\Framework\isEmpty;

class UserRegisterUseCase
{
    public function execute(String $userId)
    {
        $response = [];
        if (empty($userId)) {
            throw UserHandleException::noUserRoleAssignment();
        }

        $user = User::query()->where('onesignal_sub_id', $userId)->get();

        if ($user->isEmpty()) {
            User::query()->insert([
                'onesignal_sub_id' => $userId,
            ]);
            return true;
        }else{
            return false;
        }
    }
}
