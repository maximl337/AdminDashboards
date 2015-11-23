<?php

if (App::environment('staging')) {

    Log::useFiles('php://stderr');
}

/**
 * MAIN
 */
Route::get('/', 'PagesController@home');

/**
 * AUTH
 */
Route::get('auth/login', 'Auth\AuthController@getLogin');

Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');

Route::post('auth/register', 'Auth\AuthController@postRegister');

/**
 * TEMPLATE
 */
Route::get('browse', 'TemplateController@getTemplates');

Route::get('sell', 'TemplateController@makeTemplate');

Route::post('templates', 'TemplateController@saveTemplate');

Route::get('templates/{id}', 'TemplateController@getTemplate');

/**
 * USER DASHBOARD, PAYMENT
 */
Route::get('dashboard', 'PagesController@dashboard');

Route::post('users/payment-settings', 'UserController@updatePaymentSettings');

/**
 * PAYMENT
 */
Route::post('paypal/ipn', 'PaypalController@ipn');

Route::get('paypal/callback', 'OrderController@confirmation');


/**
 * ADMIN
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', 'PagesController@adminDashboard');

    Route::resource('users', 'UserController');

    Route::resource('templates', 'TemplateController');

    Route::post('templates/{id}', 'TemplateController@templateActions');

    Route::get('orders', 'OrderController@index');

    Route::get('payouts', 'PayoutController@index');

    Route::resource('commissions', 'CommissionController');

});