<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.home');
});

Auth::routes();

/*
*	Account URL
*   Change Password page
*   Change Password Controller
*   Update Profile page
*   Update Profile Controller
*/
Route::get('/account', 'AccountController@index')->name('account');
Route::get('/change-password', 'AccountController@showChangePasswordForm');
Route::post('/change-password','AccountController@changePassword')->name('change-password');
Route::get('/profile', 'AccountController@showChangeProfileForm');
Route::post('/profile','AccountController@updateProfile')->name('profile');

/*
* Social Linking
*/
Route::get('facebook', function () {
    return view('facebookAuth');
});
Route::get('auth/facebook', 'Auth\RegisterController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\RegisterController@handleFacebookCallback');

/*
* LinkedIn Login Route
*/
Route::get('linkedin', function () {
    return view('linkedinAuth');
});
Route::get('auth/linkedin', 'Auth\RegisterController@redirectToLinkedin');
Route::get('auth/linkedin/callback', 'Auth\RegisterController@handleLinkedinCallback');

/*
* Google Login Route
*/
Route::get('google', function () {
    return view('googleAuth');
});
Route::get('auth/google', 'Auth\RegisterController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\RegisterController@handleGoogleCallback');

/*
	Verify user email
*/
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

/*
	Search URL
*/
Route::get('/search', 'HomeController@searchListing');
Route::post('/search/api', 'HomeController@searchBCApi');