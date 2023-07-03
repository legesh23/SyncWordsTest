<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function auth(string $userID): \Illuminate\Http\JsonResponse
    {
        $user = User::find($userID);
        return response()->json([
            'token' => $user->createToken('token-name', ['server:update'])->plainTextToken
        ]);
    }
}
