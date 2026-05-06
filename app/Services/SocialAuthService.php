<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthService
{
    public function getRedirectUrl(string $provider)
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    public function authenticate(string $provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = User::Where('email', $socialUser->getEmail())->where('provider_name', $provider)->first();

        if (! $user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider_id' => $socialUser->getId(),
                'provider_name'=>$provider,
                'password' => Hash::make(Str::random(24)),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            if ($socialUser->getAvatar()) {
                $user->avatar = $socialUser->getAvatar();
                $user->save();
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];

    }
}
