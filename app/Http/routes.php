<?php

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