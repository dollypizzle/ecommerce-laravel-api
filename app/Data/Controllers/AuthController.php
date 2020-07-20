<?php

namespace App\Data\Controllers;

use App\Data\Repositories\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $user_repository;

    public function __construct(UsersRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function register () {
        $user = $this->user_repository->register();

        $token = $this->createAccessToken($user);

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token,
            'data' => $user
        ], 200);
    }

    public function login (Request $request) {
        $userLogin = $this->user_repository->login();

        if(!Auth::attempt($userLogin))
        return response()->json([
            'message' => 'Unauthorized',
            'data' => 'false'
        ], 401);

        $user = Auth::user();

        $token = $this->createAccessToken($user);

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'data' => $user
        ], 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function createAccessToken($user)
    {
        return $user->createToken('Laravel Password Grant Client')->accessToken;
    }
}
