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
    return view('welcome');
});

Auth::routes();
Route::get('dashboard', 'HomeController@index')->name('dashboard');

// Route::get('profile', function () {
//   $auth =Auth::user();
//   print '<pre>';print_r($auth);
// })->middleware('auth');

// Route::get('ID/{id}',function($id){
//    echo 'ID: '.$id;
//    //return view('foo');
// });

// Route::get('user/{name?}', function ($name = 'TutorialsPoint') { 
// 	return $name;
// });
// Auth::routes();
