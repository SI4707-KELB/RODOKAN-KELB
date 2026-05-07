<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'password' => $validated['password'],
        ]);

        $this->logInIfPossible($request, $user);

        return response()->json([
            'message' => 'Registration successful.',
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::query()
            ->when(
                isset($validated['email']),
                fn ($query) => $query->where('email', $validated['email'])
            )
            ->when(
                isset($validated['phone_number']),
                fn ($query) => $query->where('phone_number', $validated['phone_number'])
            )
            ->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $this->logInIfPossible($request, $user);

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
        ]);
    }

    private function logInIfPossible(Request $request, User $user): void
    {
        if (! $request->hasSession()) {
            return;
        }

        Auth::login($user);
        $request->session()->regenerate();
    }
}
