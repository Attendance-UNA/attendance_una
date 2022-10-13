<?php
use App\Http\Controllers\example_controller;
use App\Http\Controllers\activityController;
use Illuminate\Support\Facades\Route;

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

Route::post('person/import', 'uploadPersonController@importFile');
Route::get('person/qrcode', 'uploadPersonController@testQRCode');

Route::get('/person', function(){
    return view('person.uploadPersonView');
});

//Route for the main page
Route::get('/', function () {
    return view('home');
});
//route for activityController (method-> postFormToNewActivity)
Route::post('postFormToNewActivity', 'App\Http\Controllers\activityController@postFormToNewActivity');
//route for scan code view
Route::get('/scancode', function () {
    return view('scanningQR');
});
//route for guests dinamic table 
Route::get('guestsTable', 'App\Http\Controllers\activityController@guestsTableControl');

//route for controller
Route::post('guestsTable', 'App\Http\Controllers\activityController@guestsTableControl');

//route for guests dinamic table 
Route::post('currentGuests/insert', 'App\Http\Controllers\activityController@currentGuests');
