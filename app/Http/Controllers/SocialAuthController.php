<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

//            dd($githubUser);

            $user = User::where('github_id', $githubUser->id)
                ->orWhere('email', $githubUser->email)
                ->first();

            if ($user) {
                $user->update([
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                ]);

            } else {
                $user = User::create([
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email ?? "{$githubUser->getId()}@github.com",
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                    'password' => bcrypt(str()->random(16)), // Dummy password
                ]);

            }
            Auth::login($user);
            return redirect()->intended('/admin');
        } catch (\Exception $e) {
            return redirect('/login')->with('status', 'Login with GitHub failed. Please try again.');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                ]);

            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email ?? "{$googleUser->getId()}@google.com",
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'password' => bcrypt(str()->random(16)), // Dummy password
                ]);

            }
            Auth::login($user);
            return redirect()->intended('/admin');
        } catch (\Exception $e) {
            return redirect('/login')->with('status', 'Login with Google failed. Please try again.');
        }
    }
}
