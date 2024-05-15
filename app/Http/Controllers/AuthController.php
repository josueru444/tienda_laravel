<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect(Request $request){

        return Socialite::driver("facebook")->redirect();

    }
    public function callback(Request $request){

        try {
            $user_facebook = Socialite::driver('facebook')->user();
            
            $userExist=User::where('google_id',$user_facebook->id)->where('external_auth','facebook')->first();
            //dd($userExist);
            if($userExist){
             Auth::login($userExist);   
             return redirect('/');
            }else{
                $user = User::create(
                    
                    [   'google_id'=>$user_facebook->id ,
                        'name' => $user_facebook->name,
                        'email' => $user_facebook->email,
                        'avatar' => $user_facebook->avatar,
                        'external_auth'=>'facebook'
                    ]
                );
                Auth::login($user);
                session_start();
                $_SESSION['username']=$user_facebook->name;
                return redirect('/');
            }
            
        } catch (\Exception $e) {
            dd($e);
        }

    }
}
