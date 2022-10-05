<?php
use App\Http\Controllers\example_controller;
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

Route::get('/', function () {
    return view('welcome');
});
