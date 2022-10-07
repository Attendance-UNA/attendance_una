<?php
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

<<<<<<< Updated upstream
=======
Route::get('/scancode', function () {
    return view('scanningQR');
});

>>>>>>> Stashed changes
Route::get('/', function () {
    return view('welcome');
});

/**
 *  Section routes by subcategory
 */
Route::post('subcategory/data', [SubcategoryController::class, 'insertSubcategory']);

Route::get('/subcategory', function () {
    return view('subcategory.modalSubcategoryView');
});
