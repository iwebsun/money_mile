<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;


class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account');
    }

    /**
    * Show change password form
    * 
    */

    public function showChangePasswordForm() {
        return view('auth.changepassword');
    }

    /**
    *   Change password
        */
    
    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
        // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
        //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            //'current-password' => 'required',
            'current-password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        /*
            Change Password
        */
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    /**
    *  Change Profile page
    */

    public function showChangeProfileForm() {
        return view('auth.updateProfile');
    }

    /**
    *  Change Profile page
    */
    public function updateProfile(Request $request) {
        $a = $request->get('age');

        print '<pre>';
            print_r($a);
        print '</pre>';
        die('vipin');
    }

} 
