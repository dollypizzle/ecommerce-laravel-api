<?php

namespace App\Http\Controllers;

use App\Data\Repositories\Users\UsersRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $user_repository;

    public function __construct(UsersRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function register()
    {
        $input = request()->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'phonenumber' => 'required',
            'password' => 'required|string'
        ]);

        $input['password'] = bcrypt($input['password']);

        $user = $this->user_repository->create($input);

        $token = $this->createAccessToken($user);

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'message' => 'User Created Successfully!',
        ], 200);
    }

    public function login()
    {
        $input = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($input))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = Auth::user();

        $token = $this->createAccessToken($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'success' => true,
            'message' => 'You Have Logged in Successfully!'
        ], 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();

        $token->revoke();

        $response = [
            'message' => 'You have logged out successfully!'
        ];

        return response($response, 200);
    }

    public function createAccessToken ($user) {
        return $user->createToken('App Access Token')->accessToken;
    }

}
