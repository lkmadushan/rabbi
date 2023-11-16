<?php

namespace App\Http\Controllers;

use App\Exceptions\RegisterUserException;
use App\UseCases\RegisterUserUseCase;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @throws RegisterUserException
     */
    public function store(Request $request, RegisterUserUseCase $registerUseCase)
    {
        $registerUseCase->execute($request->userKey);

        return http_response_code(201);
    }
}

