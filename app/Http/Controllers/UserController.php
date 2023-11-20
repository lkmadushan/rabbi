<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\UseCases\RegisterUserUseCase;

class UserController extends Controller
{
    public function store(Request $request, RegisterUserUseCase $registerUseCase): Response
    {
        try {
            $registerUseCase->execute($request->input('onesignal_id'));

            return response()->noContent();
        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

