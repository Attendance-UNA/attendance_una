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


// --------------------------ACTIVITIES ROUTES-----------------------------------
//route for activityController (method-> startActivity)
Route::post('startActivity', 'App\Http\Controllers\activityController@startActivity');
//route for scan code view
Route::get('/scancode', function () {
    return view('activity/scanningQR');
});

//route for guests dinamic table 
Route::get('guestsTable', 'App\Http\Controllers\activityController@guestsTableControl');

//route for controller
Route::post('guestsTable', 'App\Http\Controllers\activityController@guestsTableControl');

//route for guests dinamic table 
Route::post('currentGuests/insert', 'App\Http\Controllers\activityController@currentGuests');

//Route to crud activities
Route::get('/createactivities', function () {
    return view('activity/createUpdateActivities');
});
//route for get activity subcategory list select 
Route::post('activitysubcategory/getlist', 'App\Http\Controllers\activityController@subcategoryList');

//route for get activity list 
Route::post('activities/getlist', 'App\Http\Controllers\activityController@activitiesList');

//route for get Activity Started datas
Route::post('activities/getActivityStartedById', 'App\Http\Controllers\activityController@getActivityStartedById');

//route for get Activity x id datas
Route::post('activities/getActivityById', 'App\Http\Controllers\activityController@getActivityById');

//route for get Activity x id datas
Route::post('activities/getGuestsByActivityId', 'App\Http\Controllers\activityController@getGuestsByActivityId');

//route for post activity insert  
Route::post('activity/insert', [activityController::class, 'insertActivity']);
//route for post activity update  
Route::post('activity/update', [activityController::class, 'updateActivity']);

//route for set finish activity   
Route::post('activity/finish', [activityController::class, 'finishActivity']);
// --------------------------END ACTIVITIES ROUTES-----------------------------------
/**
 *  Section routes by subcategory
 */
Route::post('subcategory/insert', [SubcategoryController::class, 'insertSubcategory']);

Route::get('subcategory/getdata', [SubcategoryController::class, 'getSubcategories']);

Route::post('subcategory/update', [SubcategoryController::class, 'updateSubcategory']);
/**
 *  Section routes by subcategory
 */
Route::post('subcategory/insert', [SubcategoryController::class, 'insertSubcategory']);

Route::get('subcategory/getdata', [SubcategoryController::class, 'getSubcategories']);

Route::post('subcategory/update', [SubcategoryController::class, 'updateSubcategory']);

/**
 * Section routes by reports
 */
Route::post('report/requestTableNameActivity', [reportController::class, 'requestTableNameActivity']);

Route::post('report/requestDataNameActivity', [reportController::class, 'requestDataNameActivity']);

Route::post('report/printReportNameActivity', [reportController::class, 'printReportNameActivity']);

Route::post('report/requestDataDate', [reportController::class, 'requestDataDate']);

Route::post('report/printReportDate', [reportController::class, 'printReportDate']);

Route::post('report/requestDataPerson', [reportController::class, 'requestDataPerson']);

Route::post('report/printReportPerson', [reportController::class, 'printReportPerson']);

Route::post('report/requestTableDataPerson', [reportController::class, 'requestTableDataPerson']);

Route::get('report/deleteGarbageReportPDF', [reportController::class, 'deleteGarbageReportPDF']);