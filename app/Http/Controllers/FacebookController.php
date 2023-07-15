<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function provider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();

            $oldUser = User::where('fb_id', $fbUser->getId())->first();
            if (!$oldUser) {

                $newUser = User::create([
                    'name' => $fbUser->getName(),
                    'email' => $fbUser->getEmail(),
                    'fb_id' => $fbUser->getId(),
                ]);

                Auth::login($newUser);

                return redirect()->route('welcome');
            } else {
                Auth::login($oldUser);
            }
        } catch (\Throwable $th) {
            dd('Something Went wrong'.$th->getMessage());
        }
    }
}
