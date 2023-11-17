<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\UseCases\RegisterUserUseCase;
use App\Exceptions\RegisterUserException;

class UserController extends Controller
{
    public function store(Request $request, RegisterUserUseCase $registerUseCase): JsonResponse
    {
        try {
            $registerUseCase->execute($request->input('onesignal_id'));

            return response()->json([], Response::HTTP_OK);
        } catch (RegisterUserException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

