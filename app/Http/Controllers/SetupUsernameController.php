<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SetupUsernameController extends Controller
{
    public function index()
    {
        return view('auth.setup_username');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'alpha_dash'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = auth()->user();
        $user->username = $request->username;
        $user->name = $request->name;

        $user->save();

        return redirect()->route('dashboard');

    }

    public function check(Request $request) 
    {
        $username = $request->query('username');

        if(!$username) return response()->json([
            'status' => 'empty'       
        ]);

        $exists = User::where('username', $username)->exists();

        if($exists) {
            return response()->json(['status' => 'taken']);
        } else {
            return response()->json(['status' => 'available']);
        }
    }
}
