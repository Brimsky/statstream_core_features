<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    /**
        In your Laravel controller that handles showing the profile
        Assuming you have a method in a controller that prepares data for the profile page
    **/
    public function show(Request $request)
    {
        return Inertia::render('Profile', [
            'user' => $request->user()->load('vipStatus'),
            'mustVerifyEmail' => $request->user()->hasVerifiedEmail(),
            'status' => session('status'),
        ]);
    }

    /**
        app/Http/Controllers/ProfileController.php
        in ProfileController.php
        function to become VIP user
    **/
    public function becomeVip(Request $request)
    {
        $user = $request->user();
        $vip = $user->vipStatus()->firstOrCreate([
            'user_id' => $user->id
        ]);

        $vip->status = !$vip->status; // This toggles the status
        $vip->save();

        return redirect()->route('profile.edit')->with('message', 'VIP status updated successfully.');
    }
}
