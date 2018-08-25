<?php
namespace App\Http\Controllers\Auth;

use App\Mail\VerifyMail;
use App\User;
use App\Http\Controllers\Controller;
use App\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Socialite;
use Auth;
//use Exception;
//use Illuminate\Http\File;
//use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|string|max:100',
            'email'     => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|regex:/[0-9]{10}/|digits:10',
            //'password'  => 'required|string|min:6|confirmed',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {  

        /*$createUser = [
            'social_id'     => $data['_token'],
            'social_name'   => 'Email',
            'name'          => $data['name'],
            'email'         => $data['email'],
            'mobile'        => $data['mobile'],
            'password'      => bcrypt($data['password']),
        ];
        
        return User::create($createUser);*/
        
        $user = User::create([
            'social_id'     => $data['_token'],
            'social_name'   => 'Email',
            'name'          => $data['name'],
            'email'         => $data['email'],
            'mobile'        => $data['mobile'],
            'password'      => bcrypt($data['password']),
        ]);

        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
        
        Mail::to($user->email)->send(new VerifyMail($user));
        
        return $user;
    }

    /**
     * redirect to facebook login
     *
     */
    public function redirectToFacebook() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle facebook callback and save & login user
     *
     */
    public function handleFacebookCallback(User $user) {

            $fbUser = Socialite::driver('facebook')->user();

            if(User::where('email', '=', $fbUser->getEmail())->first()){
                $checkUser = User::where('email', '=', $fbUser->getEmail())->first();
                Auth::login($checkUser);
                return redirect('/login');
            }
            
            $user->social_id = $fbUser->getId();
            $user->social_name = 'Facebook';
            $user->name = $fbUser->getName();
            $user->email = $fbUser->getEmail();
            $user->mobile = '';
            $user->avatar = $fbUser->getAvatar();
            $user->verified = 1;
            $user->password = bcrypt($fbUser->getId());
            
            $user->save();
        
            Auth::login($user);
            return redirect('/account');
    }

    /**
     * redirect to linkedIn login
     *
     */
    public function redirectToLinkedin() {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Handle linkedIn callback and save & login user
     *
     */
    public function handleLinkedinCallback(User $user) {

        $linkedINUser = Socialite::driver('linkedin')->user();
        
        if(User::where('email', '=', $linkedINUser->getEmail())->first()){
            $checkUser = User::where('email', '=', $linkedINUser->getEmail())->first();
            Auth::login($checkUser);
            return redirect('/login');
        }
        
        $user->social_id = $linkedINUser->getId();
        $user->social_name = 'LinkedIn';
        $user->name = $linkedINUser->getName();
        $user->email = $linkedINUser->getEmail();
        $user->mobile = '';
        $user->avatar = $linkedINUser->getAvatar();
        $user->verified = 1;
        $user->password = bcrypt($linkedINUser->getId());
        
        $user->save();
    
        Auth::login($user);
        return redirect('/account');
    }

    /**
     * redirect to google login
     *
     */
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle google callback and save & login user
     *
     */
    public function handleGoogleCallback() {

        $googleUser = Socialite::driver('google')->user();
        
        if(User::where('email', '=', $googleUser->getEmail())->first()){
            $checkUser = User::where('email', '=', $googleUser->getEmail())->first();
            Auth::login($checkUser);
            return redirect('/login');
        }
        
        $user->social_id = $googleUser->getId();
        $user->social_name = 'Google';
        $user->name = $googleUser->getName();
        $user->email = $googleUser->getEmail();
        $user->mobile = '';
        $user->avatar = $googleUser->getAvatar();
        $user->verified = 1;
        $user->password = bcrypt($googleUser->getId());
        
        $user->save();
    
        Auth::login($user);
        return redirect('/account');
    }
    
    /**
    * Verify User using token
    */
    public function verifyUser($token) {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
 
        return redirect('/login')->with('status', $status);
    }

     protected function registered(Request $request, $user) {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }
}