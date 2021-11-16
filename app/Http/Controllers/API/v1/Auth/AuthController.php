<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Dotenv\Loader\Resolver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate Form Inputs
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        // Insert Into DataBase
        resolve(UserRepository::class)->create($request);

        return response()->json(['message' => "user created successfully"], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        // Validate Form Inputs
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($request->only(['email', 'password',]))) {
            return response()->json(Auth::user(), Response::HTTP_OK);
        }
        throw ValidationException::withMessages([
            'email' => 'Incorrect Credential.'
        ]);
    }

    public function user() // for show information user
    {
        return response()->json(Auth::user(), Response::HTTP_OK);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => "logged out Successfully"
        ], Response::HTTP_OK);
    }
}
