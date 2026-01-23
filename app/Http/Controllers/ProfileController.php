<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $links = $user->links()->orderBy('position', 'asc')->get();
        return view('public_profile', [
            'user' => $user,
            'links' => $links,
        ]);
    }
}
