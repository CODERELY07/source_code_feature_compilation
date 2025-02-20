<?php

namespace App\Http\Controllers;

use App\Models\SocialLogin;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Log;
use Session;

class SocialLoginController extends Controller
{
    public function toProvider($driver){
        return Socialite::driver($driver)->redirect();
    }
    public function handleCallback($driver) {
        try {
            $user = Socialite::driver($driver)->user();
    
            // Check if user is retrieved
            if (!$user) {
                return redirect('/login')->withErrors(['msg' => 'Unable to retrieve user information.']);
            }
    
            $user_account = SocialLogin::where('provider', $driver)
                ->where('provider_id', $user->getId())
                ->first();
    
            if ($user_account) {
                Auth::login($user_account->user);
                Session::regenerate();
                return redirect()->intended('dashboard');
            }
    
            // Check if the email already exists
            $db_user = User::where('email', $user->getEmail())->first();
            $name = $user->getName() ?: 'Unknown User';
    
            // If user already exists with that email but not the same provider
            if ($db_user) {
                $existing_social_account = SocialLogin::where('user_id', $db_user->id)->first();
                if ($existing_social_account && $existing_social_account->provider !== $driver) {
                    return redirect('/login')->withErrors(['msg' => 'This email is already linked to a different social account.']);
                }
    
                // Link new provider
                SocialLogin::create([
                    'provider' => $driver,
                    'provider_id' => $user->getId(),
                    'user_id' => $db_user->id,
                ]);
            } else {
                // Create a new user
                $db_user = User::create([
                    'name' => $name,
                    'email' => $user->getEmail(),
                    'password' => bcrypt(rand(1000, 9999)), // Consider changing this logic
                ]);
                SocialLogin::create([
                    'provider' => $driver,
                    'provider_id' => $user->getId(),
                    'user_id' => $db_user->id,
                ]);
            }
    
            Auth::login($db_user);
            Session::regenerate();
    
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => $e->getMessage()]);
        }
    }
    
}
