<?php

namespace App\Http\Controllers\Profil;

use App\Http\Controllers\Controller;
use App\Service\Sms\SmsSender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PhoneController extends Controller
{
    private $sms;

    
   public function __construct(SmsSender $sms) {
    /** @var SmsSender $sms */
        $this->sms = $sms;
    
   }
   

   
    /**
     * @param Request $request
     * 
     * @return void
     */
    public function request(Request $request) {
    /** @var User $user */    
    $user = Auth::user();
    try {
        $token = $user->requestPhoneVerification(Carbon::now());
        $this->sms->send($token, $user->phone);
    } catch (\DomainException $e) {
        
        $request->session()->flash('error', $e->getMessage());
    }

    return redirect()->route('profil.personal.verifyform'); 
    }

    public function form() {
        /** @var User $user */    
        $user = Auth::user();

        return view('profil.phone', compact(['user']));
    }

    public function update(Request $request) {
        $this->validate($request, ['token' => 'required|string']);
        /** @var User $user */    
        $user = Auth::user();

        try {
            $user->verifyToken($request['token'], Carbon::now());
        } catch ( \DomainException $e) {
            return redirect()->route('profil.personal')->with('error', $e->getMessage());
        }

        return redirect()->route('profil.personal');


    }

    public function auth() {

        /** @var User $user */    
        $user = Auth::user();
       $user->switchPhoneAuth();
       return redirect()->route('profil.personal');
    }




}
