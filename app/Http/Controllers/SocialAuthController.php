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

            $user = User::where('github_id', $githubUser->id)
                ->orWhere('email', $githubUser->email)
                ->first();

            if ($user) {
                $user->update([
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                ]);

                Auth::login($user);

                return redirect()->intended('/dashboard');
            } else {
                $user = User::create([
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email,
                    'github_id' => $githubUser->id,
                    'github_token' => $githubUser->token,
                    'password' => bcrypt(str()->random(16)), // Dummy password
                ]);

                Auth::login($user);

                return redirect()->intended('/dashboard');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('status', 'Login with GitHub failed. Please try again.');
        }
    }
}
