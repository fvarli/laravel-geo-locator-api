<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * User registration
     */
    public function register(RegisterRequest $request)
    {
        $this->authService->register($request->validated());
        return $this->success(null, "User registered successfully", 201);
    }

    /**
     * User login
     */
    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return $this->error("Invalid credentials", 401);
        }

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], "Login successful");
    }

    /**
     * User logout
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return $this->success(null, "Logged out successfully");
    }

    /**
     * Get authenticated user info
     */
    public function user(Request $request)
    {
        return $this->success(new UserResource($this->authService->user($request)), "User data retrieved successfully");
    }
}
