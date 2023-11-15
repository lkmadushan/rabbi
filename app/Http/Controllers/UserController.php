<?php

namespace App\Http\Controllers;

use App\UseCases\UserRegisterUseCase;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        if (app(UserRegisterUseCase::class)->execute($request->userId)) {
            $response=['Status'=>'1','massage'=>'User added successfully'];
        }else{
            $response=['Status'=>'0','massage'=>'User already exists'];
        }
        return $response;
    }
}
