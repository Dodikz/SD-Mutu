<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'jabatan' => $user->jabatan,
                'alamat' => $user->alamat,
                'no_hp' => $user->no_hp,
            ];
        });
        return response()->json($users);
    }

    public function show(Request $request)
    {
        $user = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->find($request->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'jabatan' => $user->jabatan,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
        ]);
    }
}
