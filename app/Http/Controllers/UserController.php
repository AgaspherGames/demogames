<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('userList', compact('users'));
    }
    public function show(Request $request, string $username) {
        $user = User::where("username", $username)->first();
        if (!$user){
            return back();
        }
        return view('userPage', compact('user'));
    }
    public function ban(Request $request, string $username) {
        $user = User::where("username", $username)->first();
        if (!$user){
            return back();
        }
        $data = $request->validate([
            "reason"=>["required"]
        ]);
        $user->ban_reason = $data['reason'];
        $user->save();

        return view('userPage', compact('user'));
    }
}
