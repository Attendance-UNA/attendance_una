<?php
use App\Http\Controllers\example_controller;
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
Route::get('/scancode', function () {
    return view('scanningQR');
});
Route::get('/', function () {
    return view('home');
});

/**
 *  Section routes by subcategory
 */
Route::post('subcategory/insert', [SubcategoryController::class, 'insertSubcategory']);

Route::get('subcategory/getdata', [SubcategoryController::class, 'getSubcategories']);

Route::post('subcategory/update', [SubcategoryController::class, 'updateSubcategory']);