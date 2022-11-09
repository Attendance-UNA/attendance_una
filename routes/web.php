<?php
use App\Http\Controllers\example_controller;
use App\Http\Controllers\activityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubcategoryController;

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

//route for post activity insert  
Route::post('activity/insert', [activityController::class, 'insertActivity']);
//route for post activity update  
Route::post('activity/update', [activityController::class, 'updateActivity']);
// --------------------------END ACTIVITIES ROUTES-----------------------------------
/**
 *  Section routes by subcategory
 */
Route::post('subcategory/insert', [SubcategoryController::class, 'insertSubcategory']);

Route::get('subcategory/getdata', [SubcategoryController::class, 'getSubcategories']);

Route::post('subcategory/update', [SubcategoryController::class, 'updateSubcategory']);