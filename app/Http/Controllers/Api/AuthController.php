<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->notify(new WelcomeNotification($user->name));

        $token = $user->createToken('api')->plainTextToken;

        return $this->success(['token' => $token, 'user' => $user], 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', 401);
        }

        $token = auth()->user()->createToken('api')->plainTextToken;

        return $this->success(['token' => $token, 'user' => auth()->user()], 'Login successfull');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success([], 'Logged out');
    }
}
