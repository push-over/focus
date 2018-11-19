<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Auth;

class AuthenticationController extends Controller
{
    public function getSocialRedirect($social)
    {
        try {
            return Socialite::with($social)->redirect();
        }catch (\InvalidArgumentException $e) {
            return redirect('/login');
        }
    }

    public function getSocialCallback($social)
    {
        $socialUser = Socialite::with($social)->user();

        $user = User::where('provider_id','=',$socialUser->id)
                    ->where('provider', '=', $social)
                    ->first();

        if($user == null) {
            $newUser = new User;

            $newUser->name        = $socialUser->getName();
            $newUser->email       = $socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
            $newUser->avatar      = $socialUser->getAvatar();
            $newUser->password    = '';
            $newUser->provider    = $social;
            $newUser->provider_id = $socialUser->getId();

            $newUser->save();
            $user = $newUser;
        }

        Auth::login($user);

        return redirect('/');
    }
}
