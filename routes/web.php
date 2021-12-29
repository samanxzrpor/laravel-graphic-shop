<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('frontend.index');
});


Route::prefix('admin')->group(function () {

    Route::get('', function () {
        return view('admin.dashbord');
    });

    Route::prefix('categories')->group(function () {

        Route::get('', [CategoriesController::class , 'showAll'])->name('admin.categories');

        Route::get('create', [CategoriesController::class ,'showCreatePage'])->name('admin.categories.showCreatePage');

        Route::post('', [CategoriesController::class ,'store'])->name('admin.categories.store');

        Route::delete('{cat_id}/delete', [CategoriesController::class ,'delete'])->name('admin.categories.delete');

        Route::get('{cat_id}/update', [CategoriesController::class ,'showUpdatePage'])->name('admin.categories.showUpdatePage');

        Route::match(['put' ,'patch'],'{cat_id}/update', [CategoriesController::class ,'update'])->name('admin.categories.update');
    });

});