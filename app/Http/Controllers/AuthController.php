<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)  {}

        public function register(RegisterRequest $request)
    {
        // Sent to the request handler for validation
        $validatedData = $request->validated();

        // we pass this value to the register method in AuthService
        $result = $this->authService->register($validatedData);

        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        // Sent to the request handler for validation
        $validatedData = $request->validated();

        // we pass this value to the login method in AuthService
        $token = $this->authService->login($validatedData);

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        // we pass this value to the logout method in AuthService
        $this->authService->logout($request);

        return response()->json(['message' => 'Logged out successfully']);
    }
}
