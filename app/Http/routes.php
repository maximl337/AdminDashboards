<?php


Route::get('tempUrl/{id}', 'TemplateController@testTempUrl');

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

Route::get('paypal/callback', function() {

    return "Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.sandbox.paypal.com/ca to view details of this transaction.";
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'AdminController@index');
    
});