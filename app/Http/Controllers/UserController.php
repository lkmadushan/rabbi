<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\UseCases\RegisterUserUseCase;
use App\Exceptions\RegisterUserException;

class UserController extends Controller
{
    /**
     * @throws RegisterUserException
     */
    public function store(Request $request, RegisterUserUseCase $registerUseCase): JsonResponse
    {
        $registerUseCase->execute($request->input('onesignal_id'));

        return response()->json();
    }
}

