<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function create($request): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function leaderboards()
    {
        return User::all()->orderByDesc('score')->paginate(10);
    }

    public function isBlock(): bool
    {
        return (bool) auth()->user()->is_block;
    }
}
