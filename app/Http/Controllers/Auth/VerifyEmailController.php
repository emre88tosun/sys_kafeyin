<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request)
    {

        if($request->user() && $request->user()->hasVerifiedEmail()){
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $user = User::find($request->id);
        $nowts = Carbon::now()->timestamp;


        if(!$request->hasValidSignature()){
            return view('verify_email_v2')->with([
                'nonUser'=>false,
                'hashErr'=>false,
                'verified'=>false,
                'expired'=>false,
                'invalidSign'=>true,
            ]);
        }

        if(is_null($user)){
            return view('verify_email_v2')->with([
                'nonUser'=>true,
                'hashErr'=>false,
                'verified'=>false,
                'expired'=>false,
                'invalidSign'=>false,
            ]);
        }
        if($request->hash != sha1($user->email)){
            return view('verify_email_v2')->with([
                'nonUser'=>false,
                'hashErr'=>true,
                'verified'=>false,
                'expired'=>false,
                'invalidSign'=>false,
            ]);
        }
        if ($user->hasVerifiedEmail()) {
            return view('verify_email_v2')->with([
                'nonUser'=>false,
                'hashErr'=>false,
                'verified'=>true,
                'expired'=>false,
                'invalidSign'=>false,
            ]);
        }
        if($nowts > $request->expires){
            return view('verify_email_v2')->with([
                'nonUser'=>false,
                'hashErr'=>false,
                'verified'=>false,
                'expired'=>true,
                'invalidSign'=>false,
            ]);
        }


        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view('verify_email_v2')->with([
            'nonUser'=>false,
            'hashErr'=>false,
            'verified'=>true,
            'expired'=>false,
            'invalidSign'=>false,
        ]);

    }
}
