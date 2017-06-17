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

/*	Patient Routes
|--------------------------------------------------------------------------| */

Route::get('/register', 'Core\PatientsController@create');

Route::post('/register', 'Core\PatientsController@store');

Route::get('/view/{id}', 'Core\PatientsController@view');

Route::get('/view-record/{id}', 'Core\PatientsController@viewrecord');

Route::get('/consult/{id}', 'Core\PatientsController@consult')->name('consult');

Route::get('/update-patient/{id}', 'Core\PatientsController@updatepatient');

Route::post('/update-patient', 'Core\PatientsController@postupdatepatient');

Route::get('/confirm-patient/{id}', 'Core\PatientsController@deletepatient');

Route::post('/delete-patient', 'Core\PatientsController@postdeletepatient');

/*	Waiting Routes
|--------------------------------------------------------------------------| */

Route::get('/waiting', 'Core\WaitingController@index');

Route::get('/waitlist/{id}', 'Core\WaitingController@waitlist');

/*	Clinicals Routes
|--------------------------------------------------------------------------| */

Route::get('/', 'Core\ClinicalsController@index')->name('home');

Route::post('/', 'Core\ClinicalsController@search');

Route::get('/history/{id}', 'Core\ClinicalsController@history');

Route::post('/new-history', 'Core\ClinicalsController@new');

Route::get('/update-history/{id}', 'Core\ClinicalsController@update');

Route::post('/update-history', 'Core\ClinicalsController@updatehistory');

Route::get('/confirm-history/{id}', 'Core\ClinicalsController@deletehistory');

Route::post('/delete-history', 'Core\ClinicalsController@postdeletehistory');
