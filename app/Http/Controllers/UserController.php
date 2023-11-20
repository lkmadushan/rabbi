<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\UseCases\RegisterUserUseCase;
use App\Exceptions\RegisterUserException;

class UserController extends Controller
{
    public function store(Request $request, RegisterUserUseCase $registerUseCase): Response
    {
        try {
            $registerUseCase->execute($request->input('onesignal_id'));

            return response()->noContent();
        } catch (RegisterUserException $e) {
            return response($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

