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

Route::get('/referrals/{id}', 'Core\ClinicalsController@referrals');

Route::get('/referral/{id}/{referral}', 'Core\ClinicalsController@postreferral');

Route::post('/add-referral/{id}/{referral}', 'Core\ClinicalsController@addreferral');


/*	Investigation Routes
|--------------------------------------------------------------------------| */
Route::resource('labs', 'Core\LabsController', ['only' => [
		    'index', 'create', 'edit'
		]]);

Route::get('/lab-create/{id}', 'Core\LabsController@create');

Route::post('/lab-create/{id}', 'Core\LabsController@store');

Route::post('/update-lab/{id}', 'Core\LabsController@update')->name('update-lab');

Route::get('/confirm-lab/{id}', 'Core\LabsController@confirmdestroy');

Route::post('/delete-lab/{id}', 'Core\LabsController@postdeletelab');

Route::get('/investigations/{id}', 'Core\LabsController@investigations');

Route::get('/radiology-create/{id}', 'Core\RadiologyController@createradiology');

Route::post('/radiology-create/{id}', 'Core\RadiologyController@postradiology');

Route::get('/remove-radiology/{lab_id}/{radio_lab}', 'Core\RadiologyController@removeradiology');

Route::post('/remove-radiology/{lab_id}/{radio_lab}', 'Core\RadiologyController@postremoveradiology');

Route::get('/radiology-add/{lab_id}', 'Core\RadiologyController@addradiology');

Route::post('/radiology-add/{lab_id}', 'Core\RadiologyController@postaddradiology');


/*	Pharmacy Routes
|--------------------------------------------------------------------------| */
Route::get('/pharmacy', 'Core\DrugsController@getpharmacy');

Route::get('/medications', 'Core\DrugsController@getmedications');

Route::get('/medication/{id}', 'Core\DrugsController@getmedication');

Route::post('/medication/{id}', 'Core\DrugsController@postmedication');

Route::post('/delete-medication/{id}', 'Core\DrugsController@deletemedication');

Route::resource('drugs', 'Core\DrugsController', ['only' => [
		   'create', 'edit'
		]]);

Route::get('/add-drug', 'Core\DrugsController@adddrug');

Route::post('/add-drug', 'Core\DrugsController@postadddrug');

Route::post('/search-drug', 'Core\DrugsController@postsearchdrug');

Route::get('/drug/{id}', 'Core\DrugsController@getdrug')->name('drug');

Route::post('/add-stock/{id}', 'Core\DrugsController@addstock');

Route::post('/remove-stock/{id}', 'Core\DrugsController@removestock');

Route::get('/delete-drug/{id}', 'Core\DrugsController@deletedrug');

Route::post('/delete-drug/{id}', 'Core\DrugsController@postdeletedrug');


/*	Reports Routes
|--------------------------------------------------------------------------| */
Route::get('/reports', 'Core\ReportsController@index');

Route::get('/moh-reports', 'Core\ReportsController@diseasesreports');

Route::post('/moh-reports', 'Core\ReportsController@postdiseases');

Route::get('/outpatient-reports', 'Core\ReportsController@outpatientreports');

Route::post('/outpatient-reports', 'Core\ReportsController@postoutpatient');


/*	Settings Routes
|--------------------------------------------------------------------------| */
Route::get('/settings', 'Core\SettingsController@settings');

Route::get('/main-settings', 'Core\SettingsController@mainsettings');

Route::post('/main-settings', 'Core\SettingsController@updatesettings');

Route::get('/about-chealth', 'Core\SettingsController@aboutchealth');

Route::get('/update-chealth', 'Core\SettingsController@updatechealth');

Route::get('/upgrade-chealth', 'Core\SettingsController@upgradechealth');

Route::get('/chealth-license', 'Core\SettingsController@chealthlicense');



