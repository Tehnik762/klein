<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\Sms\SmsSender;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $sms;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SmsSender $sms)
    {
        $this->middleware('guest')->except('logout');
        $this->sms = $sms;
    }
    
    public function authenticated(Request $request, User $user)
    {
        if ($user->status != User::STATUS_ACTIVE) {
            $this->guard()->logout();
            return back()->with('error', __('auth.NotActive'));
        } 
        if ($user->isPhoneAuthActivated()) {
            $this->guard()->logout();
            $token = random_int(10000, 99999);
            $request->session()->put('auth', [
                "id" => $user->id,
                "token" => $token,
                "remember" => $request->filled('remember'),
            ]);
            $this->sms->send($user->phone, $token);
            return redirect()->route('auth.phone');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function phone(Request $request) {
        $auth = $request->session()->get('auth');
        if (!isset($auth)) {
            return redirect()->back()->with('error', __('admin.error'));
        }
        return view('auth.phone');

    }

    public function verify(Request $request) {

            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }
            $auth = $request->session()->get('auth');

            $this->validate($request, [
                "token" => "required|string"
            ]);

            /** @var User $user */
            $user = User::findOrFail($auth['id']);

            if ($request['token'] == $auth['token']) {
                $request->session()->flush();
                Auth::login($user, $auth['remember']);
                return redirect()->intended($this->redirectPath());
            }
            $this->incrementLoginAttempts($request);
            throw ValidationException::withMessages(['token' => __('admin.incorrect_token')]);

    }

}
