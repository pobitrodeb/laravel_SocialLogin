<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $findUser = user::where('facebook_id', $user->id)->fist();
        
        if($findUser){

            Auth::login($findUser); 
            }
            else {
            $new_user = new User(); 
            $new_user->name                = $user->name;
            $new_user->email               = $user->email;
            $new_user->facebook_id         = $user->facebook_id;
            $new_user->password            = bcrypt('12345678');
            $new_user->save();
            Auth::login($new_user);
            return redirect('/home');
    }
    
}