<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{    
    /**
     * register
     *
     * @param  Request $request
     * @return Response
     */
    public function register(RegisterRequest $request): Response
    {
        $newUser = User::Create($request->validated());

        return $newUser ? response(['message' => 'registered successfully'], 200) : response(['message' => 'failed to register', 'error' => $newUser], 400);
    }
}
