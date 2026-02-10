<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ProfileVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show($username)
    {
        // 1. Cari user berdasarkan username
        // firstOrFail() akan otomatis menampilkan 404 jika user tidak ditemukan
        $user = User::where('username', $username)->firstOrFail();

        $today = now()->startOfDay();

        $hasVisited = ProfileVisit::where('user_id', $user->id)
            ->where('ip_address', request()->ip())
            ->where('created_at', '>=', $today)
            ->exists();

        if (!$hasVisited) {
            ProfileVisit::create([
                'user_id' => $user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        // 2. Ambil link user (tanpa tanda kurung, seperti yang kita bahas sebelumnya)
        $links = $user->links()->orderBy('position', 'asc')->get();

        // 3. Tampilkan view
        return view('public_profile', [
            'user' => $user,
            'links' => $links
        ]);
    }
    /**
     * Show the form for editing the user's profile.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $request->user()->fill($request->validated());

        if($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if($request->user){
                Storage::delete('public/' . $request->user()->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
