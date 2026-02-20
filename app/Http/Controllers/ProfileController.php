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

        $links = $user->links()->orderBy('position', 'asc')->get();

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
        $validated = $request->validated();


        $request->user()->fill($validated);

        if($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if($request->hasFile('avatar')) {
            if($request->user()->avatar) {
                Storage::disk('public')->delete($request->user()->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        $request->user()->save();

        return Redirect::back()->with('success', 'Tampilan profil berhasil diupdate!');
    }
    
    public function updateAppearance(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'bg_type' => 'required|in:color,gradient,image',
            'bg_gradient' => 'nullable|string',
            'bg_color' => 'nullable|string',
            'bg_image' => 'nullable|image|max:2048',
            'btn_shape' => 'nullable|string',
            'btn_style' => 'nullable|string',
        ]);

        $user->bg_type = $request->bg_type;
        $user->bg_color = $request->bg_color;
        $user->bg_gradient = $request->bg_gradient;

        if($request->has('btn_shape')) {
            $user->btn_shape = $request->btn_shape;
        }

        if($request->has('btn_style')) {
            $user->btn_style = $request->btn_style;
        }

        if($request->hasFile('bg_image')) {
            if($user->bg_image) {
                Storage::disk('public')->delete($user->bg_image);
            }

            $user->bg_image = $request->file('bg_image')->store('backgrounds', 'public');
        }

        $user->save();

        return back()->with('success', 'Tampilan berhasil diperbarui!');
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
