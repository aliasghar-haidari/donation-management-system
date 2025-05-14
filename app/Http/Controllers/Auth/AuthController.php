<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SigninRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function signin(SigninRequest $request)
    {
        $credentials = $request->credentials();

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('user_name', $credentials['user_name'])->first();

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => new UserResource($user),
        ]);
    }

    public function signout()
    {
        $user = Auth::user();

        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Signed out successfully.'
        ]);
    }
}