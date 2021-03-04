<?php

namespace App\Http\Controllers;

use App\Models\BrandNotification;
use App\Models\OwnershipApplication;
use App\Models\OwnershipApplicationReferral;
use App\Models\PreRegisteredStoreUser;
use App\Models\Store;
use App\Models\StoreLog;
use App\Models\StoreNotification;
use App\Models\User;
use App\Models\UserLog;
use App\Notifications\BrandManagerInfoEmailWithButton;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        $refCode = OwnershipApplicationReferral::whereRaw("BINARY `referralCode`= ?",[$ref])->with('brand')->first();
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
        $refExt = OwnershipApplicationReferral::whereRaw("BINARY `referralCode`= ?",[$ref])->first();

        $request->request->remove("_token");
        $request->request->add(['brandID'=>$refExt->brandID]);
        $request->request->add(['status'=>"need_approval"]);
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

    public function ilkbasvurutamamlandi(Request $request)
    {

        $aUser = Auth::user();
        if($aUser){
            return redirect('/gateway');
        }

        $success = $request->success;
        $ref = $request->referral;

        $refExt = OwnershipApplicationReferral::whereRaw("BINARY `referralCode`= ?",[$ref])->first();

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

    public function ilkbasvurutakip(Request $request)
    {
        $ref = $request->referral;
        if(!$ref){
            abort(404);
        }

        $application = OwnershipApplication::where('detail','LIKE', '%'.$ref.'%')->with('brand')->first();

        if(!$application){
            abort(404);
        }

        $detail = json_decode($application->detail,true);


        return view('basvurular.ilkbasvurutakip')->with([
            'application'=>$application,
            'detail'=>$detail,
        ]);


    }

    public function yoneticihesabiolustur(Request  $request)
    {
        $aUser = Auth::user();
        if($aUser){
            return redirect('/gateway');
        }

        $referral = $request->referral;
        if(!$referral){
            return view('custom_errors.404')->with([
                'message'=>"Referans kodu olmadan hesabınızı oluşturamazsınız."
            ]);
        }
        if(PreRegisteredStoreUser::whereRaw("BINARY `referralCode`= ?",[$referral])->doesntExist()){
            return view('custom_errors.404')->with([
                'message'=>"Sistemlerimizde kayıtlı olmayan bir referans kodu ile işleme devam edemezsiniz."
            ]);
        }

        $preUser = PreRegisteredStoreUser::whereRaw("BINARY `referralCode`= ?",[$referral])->first();

        if(User::where('email',$preUser->email)->exists()){
            abort(404);
        }

        return view('basvurular.preuserkayit')->with([
            'preUser'=>$preUser
        ]);

    }

    public function yoneticihesabigonder(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);

        $pUID = $request->pUID;
        $preUser = PreRegisteredStoreUser::where('id',$pUID)->first();
        if(!$preUser){
            return redirect()->back();
        }

        if($preUser->brandID){
            if(User::where('brandID',$preUser->brandID)->exists()){
                User::where('brandID',$preUser->brandID)->first()->update([
                    'brandID'=>null
                ]);
            }
        }

        $name = $request->name;
        $surname = $request->surname;
        $email = $request->email;
        $password = Hash::make($request->password);
        $gsm = substr($request->gsmNumber,3);
        $userType = "store";
        $isBrandManager = $preUser->isBrandManager;
        $brandID = $preUser->brandID;

        $data = [
            'name'=>$name,
            'surname'=>$surname,
            'email'=>$email,
            'password'=>$password,
            'gsmNumber'=>$gsm,
            'userType'=>$userType,
            'isBrandManager'=>$isBrandManager,
            'brandID'=>$brandID,
        ];

        $createdUser = User::create($data);

        event(new Registered($createdUser));

        if($preUser->isStoreManager){
            Store::where('id',$preUser->storeID)->first()->update([
                'email'=>$email
            ]);
        }


        $detail1 = [
            'ip'=>$request->ip(),
            'actionDateTime'=>Carbon::now()
        ];

        PreRegisteredStoreUser::where('id',$pUID)->first()->update([
            'detail'=>$detail1
        ]);

        if($preUser->applicationID){
            if($preUser->isBrandManager){
                $application = OwnershipApplication::where('id',$preUser->applicationID)->first();
                $detail = $application->detail;
                $jsonDetail = json_decode($detail,true);
                $jsonDetail['brandManagerAccountCreated'] = "true";
                OwnershipApplication::where('id',$application->id)->first()->update([
                    'detail'=>$jsonDetail
                ]);
            }
            if($preUser->isStoreManager){
                $application2 = OwnershipApplication::where('id',$preUser->applicationID)->first();
                $detail2 = $application2->detail;
                $jsonDetail2 = json_decode($detail2,true);
                $jsonDetail2['storeManagerAccountCreated'.$preUser->storeID] = "true";
                OwnershipApplication::where('id',$application2->id)->first()->update([
                    'detail'=>$jsonDetail2
                ]);
            }
        }


        if($preUser->isBrandManager){
            $data11 = [
                'brandID'=>$preUser->storeID,
                'desc'=>"Kafeyin'e hoşgeldiniz!"
            ];
            BrandNotification::create($data11);
        }

        if($preUser->isStoreManager){
            $data12 = [
                'storeID'=>$preUser->storeID,
                'desc'=>"Kafeyin'e hoşgeldiniz!"
            ];
            StoreNotification::create($data12);

            $storeLogDetail = [
                'ip'=>$request->ip()
            ];

            $storeLogData = [
                'storeID'=>$preUser->storeID,
                'userID'=>$createdUser->id,
                'desc'=>$createdUser->name." ".$createdUser->surname.", mağazaya yönetici olarak atandı.",
                'detail'=>$storeLogDetail
            ];

            StoreLog::create($storeLogData);

        }

        $logDetail = [
            'ip'=>$request->ip()
        ];

        $logData = [
            'userID'=>$createdUser->id,
            'desc'=>"Hesabınız oluşturuldu.",
            'detail'=>$logDetail
        ];

        UserLog::create($logData);





        return redirect('/login')->with([
            'managerAccountCreated'=>true
        ]);

    }
}
