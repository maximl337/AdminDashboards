<?php

use App\Contracts\FileStorage;

if (App::environment('staging')) {
    $monolog = Log::getMonolog();
    $syslog = new \Monolog\Handler\SyslogHandler('papertrail');
    $formatter = new \Monolog\Formatter\LineFormatter('%channel%.%level_name%: %message% %extra%');
    $syslog->setFormatter($formatter);

    $monolog->pushHandler($syslog);
}

Route::get('test/payout', 'PayoutController@test');

Route::get('test/payout/{id}', 'PayoutController@testPayout');

Route::get('test/payoutDetails/{id}', 'PayoutController@payoutDetails');

Route::get('test/payoutItem/{id}', 'PayoutController@payoutItem');

Route::get('/', 'PagesController@home');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::get('browse', 'TemplateController@index');

Route::get('sell', 'TemplateController@create');

Route::post('/templates', 'TemplateController@store');

Route::get('templates/{id}', 'TemplateController@show');

Route::get('dashboard', 'PagesController@dashboard');

Route::post('users/payment-settings', 'UserController@updatePaymentSettings');

Route::post('paypal/ipn', 'OrderController@paypalIPN');

Route::get('paypal/callback', 'OrderController@confirmation');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'AdminController@index');
    
});