<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public $maxAttempts = 1; // change to the max attemp you want.
    public $decayMinutes = 1; // change to the minutes you want.

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
        Validate User Login - Check status
    */
    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username() . ',verified,1',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
        ]);
    }
    
    /**
        Authenticated User - Verification of email
    */
    public function authenticated(Request $request, $user) {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
