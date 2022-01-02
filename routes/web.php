<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
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

    Route::prefix('products')->group(function () {

        Route::get('create' , [ProductsController::class , 'showCreatePage'])->name('admin.products.showCreatePage');

        Route::get('' , [ProductsController::class , 'showAll'])->name('admin.products.showAll');

        Route::post('add' , [ProductsController::class , 'addProduct'])->name('admin.products.addProduct');

        Route::get('{product_id}/download/demo' , [ProductsController::class , 'downloadDemo'])->name('product.download.demo');

        Route::get('{product_id}/download/source' , [ProductsController::class , 'downloadSource'])->name('product.download.source');

        Route::delete('{product_id}/delete', [ProductsController::class , 'delete'])->name('product.delete');
    });

});