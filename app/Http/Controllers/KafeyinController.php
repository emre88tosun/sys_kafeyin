<?php

namespace App\Http\Controllers;

use App\Models\OwnershipApplication;
use App\Models\OwnershipApplicationReferral;
use App\Models\User;
use App\Notifications\BrandManagerInfoEmailWithButton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KafeyinController extends Controller
{
    public function gateway(Request $request)
    {
        $user = Auth::user();
        if($user->userType == 'store'){
            $user = Auth::user();
            User::where('id',$user->id)->first()->update([
                'lastLogin'=>Carbon::now()->toDateTimeString(),
            ]);
            return redirect('/yoneticipaneli/anasayfa');
        }else if($user->userType == 'admin'){
            $user = Auth::user();
            User::where('id',$user->id)->first()->update([
                'lastLogin'=>Carbon::now()->toDateTimeString(),
            ]);
            return redirect('/adminpanel/anasayfa');
        }else if($user->userType == 'user'){

            return redirect('/pekyakinda');
        }else{

        }
        return $user;
    }

    public function resendverif(Request $request)
    {
        $email = $request->email;
        if(User::where('email',$email)->doesntExist()){
            return redirect()->back()->with([
                'email'=>$email
            ])
                ->withErrors([
                    'email'=>'Bu e-posta adresi ile kayıtlı bir kullanıcı bulunmamaktadır.'
                ]);
        }
        if(User::where('email',$email)->first()->email_verified_at){
            return redirect()->back()->with([
                'email'=>$email
            ])
                ->withErrors([
                    'email'=>'Bu e-posta adresi ile kayıtlı olan kullanıcı, zaten e-posta adresini doğruladı.'
                ]);
        }

        $user = User::where('email',$email)->first();
        $user->sendEmailVerificationNotification();
        return redirect()->back()->with([
            'reSent'=>true
        ]);

    }

    public function cikisyap(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function ilkbasvuru(Request $request)
    {
        $aUser = Auth::user();
        if($aUser){
            return redirect('/gateway');
        }

        $ref = $request->referral;
        if(!$ref){
            return view('custom_errors.noref');
        }

        $refCode = OwnershipApplicationReferral::where('referralCode',$ref)->with('brand')->first();
        if(!$refCode || !$refCode->isValid){
            return view('custom_errors.nonvalidref');
        }

        if($refCode->isUsed){
            return view('custom_errors.usedref');
        }

        $stos = $refCode->brand->stores;

        return view('basvurular.ilkbasvuru')->with([
            'ref'=>$refCode,
            'stos'=>$stos,
        ]);

    }

    public function ilkbasvurugonder(Request $request)
    {
        $ref = $request->referral;
        $refExt = OwnershipApplicationReferral::where('referralCode',$ref)->first();

        $request->request->remove("_token");
        $request->request->add(['brandID'=>$refExt->brandID]);
        $request->request->add(['ip'=>$request->ip()]);

        $data = [
            'brandID'=>$refExt->brandID,
            'referralID'=>$refExt->id,
            'detail'=>json_encode($request->all())
        ];

        OwnershipApplication::create($data);

        OwnershipApplicationReferral::where('id',$refExt->id)->first()->update([
            'isUsed'=>true
        ]);

        $notifUser = new User;
        $notifUser->email = $request->brandManagerEmail;
        $notifUser->name = ucfirst($request->brandManagerName);
        $notifUser->surname = ucfirst($request->brandManagerSurname);

        $details = [
            'subject'=>"Başvurunuzu aldık!",
            'user'=>$notifUser,
            'buttonName'=>"Başvuru durumu",
            'buttonUrl'=>url('/ilkbasvurutakip?referral='.$refExt->referralCode),
            'bodyText1'=>"İlk başvurunuz tarafımıza ulaştı ve ekibimiz tarafından incelendikten sonra bilgi e-postası göndereceğiz.",
            'bodyText2'=>"Başvuru sürecini, yukarıda bulunan butona tıklayarak takip edebilirsiniz.",
        ];

        $notifUser->notify(new BrandManagerInfoEmailWithButton($details));

        return redirect('/ilkbasvurutamamlandi?referral='.$refExt->referralCode.'&success=true');

    }

    public function ilkbasvurutamamlandi(Request  $request)
    {
        $success = $request->success;
        $ref = $request->referral;

        $refExt = OwnershipApplicationReferral::where('referralCode',$ref)->first();

        if(!$success || !$ref || !$refExt || $success != "true"){
            abort(404);
        }


        if(!$refExt->isUsed){
            abort(404);
        }

        return view('basvurular.ilkbasvurutamamlandi')->with([
            'ref'=>$ref
        ]);

    }

    public function checkemail(Request  $request)
    {
        $email = $request->email;
        if(User::where('email',$email)->exists()){
            $exists = true;
        }else{
            $exists = false;
        }
        return $exists;
    }
}
