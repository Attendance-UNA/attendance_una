<?php
use App\Http\Controllers\example_controller;
use App\Http\Controllers\activityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\reportController;

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
Route::get('person/download_template', 'uploadPersonController@downloadPersonTemplate');

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

/**
 *  Section routes by subcategory
 */
Route::post('subcategory/insert', [SubcategoryController::class, 'insertSubcategory']);

Route::get('subcategory/getdata', [SubcategoryController::class, 'getSubcategories']);

Route::post('subcategory/update', [SubcategoryController::class, 'updateSubcategory']);

/**
 * Section routes by reports
 */
Route::post('report/dataNameActivity', [reportController::class, 'getDataNameActivity']);

Route::post('report/desingReportNameActivity', [reportController::class, 'desingReportNameActivity']);

Route::get('report/deleteGarbageReportPDF', [reportController::class, 'deleteGarbageReportPDF']);

Route::post('report/infoDateReport', [reportController::class, 'getInfoDateReport']);

Route::post('report/desingReportDate', [reportController::class, 'desingReportDate']);

Route::post('report/dataReportIdPerson', [reportController::class, 'dataReportIdPerson']);

Route::post('report/desingReportIdPerson', [reportController::class, 'desingReportIdPerson']);