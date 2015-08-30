<?php

if (App::environment('staging')) {

    Log::useFiles('php://stderr');
}

// Route::get('test/payout', 'PayoutController@test');

// Route::get('test/payout/{id}', 'PayoutController@testPayout');

// Route::get('test/payoutDetails/{id}', 'PayoutController@payoutDetails');

// Route::get('test/payoutItem/{id}', 'PayoutController@payoutItem');

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

Route::post('templates', 'TemplateController@saveTemplate');

Route::get('templates/{id}', 'TemplateController@getTemplate');

Route::get('dashboard', 'PagesController@dashboard');

Route::post('users/payment-settings', 'UserController@updatePaymentSettings');

Route::post('paypal/ipn', 'OrderController@paypalIPN');

Route::get('paypal/callback', 'OrderController@confirmation');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'AdminController@index');

    Route::resource('users', 'UserController');

    Route::resource('templates', 'TemplateController');

    Route::get('orders', 'OrderController@index');

    Route::get('payouts', 'PayoutController@index');

    Route::resource('commissions', 'CommissionController');

});