<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    if(Auth::guest()){
        return redirect('/login');
    }else{
        return redirect('/user');
    }
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');
Route::get('register', 'HomeController@null');
Route::post('register', 'HomeController@null');

Route::get('password/reset', 'HomeController@null');
Route::post('password/email', 'HomeController@null');
Route::get('password/reset/{token}', 'HomeController@null');
Route::post('password/reset', 'HomeController@null');




Route::resource('category', 'CategoryController');
Route::get('/profile/ajax', 'ProfileController@ajax');
Route::resource('profile', 'ProfileController');





Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['auth.admin']], function () {



        Route::get('/message/ajax', 'MessageController@ajax');
        Route::post('/message/{id}/show_message', 'MessageController@show_message');
        Route::resource('message', 'MessageController');



//        Route::get('offer/{id}/delete', 'OffsController@del');
//        Route::resource('offer', 'OffsController');

        Route::get('offer/{id}/delete', 'OfController@del');
        Route::resource('off', 'OfController');

        Route::get('/payments/ajax', 'PaymentsController@ajax');

        Route::resource('payments', 'PaymentsController');

        Route::get('/user/ajax', 'UserController@ajax');
        Route::resource('user', 'UserController');


        Route::get('/pushes/ajax', 'PushController@ajax');
        Route::resource('pushes', 'PushController');

//        Route::get('settings', 'SettingController@create');
        Route::resource('setting', 'SettingController');
    });
});

Route::get('/home', 'HomeController@index');
Route::get('/access', function (){
           return view('access');
        });

