<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if (!$user) {
            $user = User::create([
                'name'        => $socialUser->getName() ?? 'User',
                'email'       => $socialUser->getEmail(),
                'provider'    => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
                'password'    => bcrypt(Str::random(32)),
                'role' => 'kasir', // 🔒 PAKSA KASIR
            ]);
        }

        Auth::login($user, true);

        return redirect('/dashboard');
    }
}
