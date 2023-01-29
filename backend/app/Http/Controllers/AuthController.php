<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{    
    /**
     * register
     *
     * @param  RegisterRequest $request
     * @return Response
     */
    public function register(RegisterRequest $request): Response
    {
        $newUser = User::create([...$request->validated(), 'password' => bcrypt($request->password)]);

        return $newUser ? response(['message' => 'registered successfully'], 200) : response(['message' => 'failed to register', 'error' => $newUser], 400);
    }

     /**
     * login
     *
     * @param  LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $user = User::whereEmail($request->email)->first();

        if(!$user) {
            return response(['message' => 'user not found'], 400);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response(['message' => 'wrong password'], 400);
        }

        $token = $user->createToken($user->email)->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 60 * 24 * 30);

        return response(['message' => 'logged in successfully'], 200)->withCookie($cookie);
    }
    
    /**
     * logout
     *
     * @param  Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        $cookie = Cookie::forget('jwt');
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'logged out successfully'], 200)->withCookie($cookie);
    }
}
