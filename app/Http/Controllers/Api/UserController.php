<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $data = $request->validate([
            "username" => ["required", "unique:users,username", "min:4", "max:60"],
            "password" => ["required", "min:8"],
        ]);
        $data['last_login'] = now();
        $data['password'] = bcrypt($data['password']);
        $data['last_login'] = now();
        $user = User::create($data);
        $token = $user->createToken("")->plainTextToken;
        return
            [
                "status" => "success",
                "token" => $token
            ];
    }
    public function signin(Request $request)
    {
        $data = $request->validate([
            "username" => ["required", "exists:users,username", "min:4", "max:60"],
            "password" => ["required", "min:8"],
        ]);

        $user = User::where("username", $data["username"])->first();
        if (!Hash::check($data["password"], $user->password)) return response('haha');
        $last_login = now();

        if ($user->tokens()->count()) {
            return response([
                "status" => "invalid",
                "message" => "Logout from last device"
            ]);
        }

        $user->last_login = $last_login;
        $user->save();

        $token = $user->tokens()->delete();

        $token = $user->createToken("")->plainTextToken;
        return
            [
                "status" => "success",
                "token" => $token
            ];
    }
    public function signout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return
            [
                "status" => "success"
            ];
    }
    public function show(string $username){
        $user = User::where('username', $username)->first();
        return new UserResource($user);
    }
}
