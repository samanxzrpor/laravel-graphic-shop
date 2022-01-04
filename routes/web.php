<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
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

        Route::get('{cat_id}/edit', [CategoriesController::class ,'edit'])->name('admin.categories.showUpdatePage');

        Route::match(['put' ,'patch'],'{cat_id}/update', [CategoriesController::class ,'update'])->name('admin.categories.update');
    });

    Route::prefix('products')->group(function () {

        Route::get('create' , [ProductsController::class , 'showCreatePage'])->name('admin.products.showCreatePage');

        Route::get('' , [ProductsController::class , 'showAll'])->name('admin.products.showAll');

        Route::post('store' , [ProductsController::class , 'storeProduct'])->name('admin.products.addProduct');

        Route::get('{product_id}/download/demo' , [ProductsController::class , 'downloadDemo'])->name('product.download.demo');

        Route::get('{product_id}/download/source' , [ProductsController::class , 'downloadSource'])->name('product.download.source');

        Route::delete('{product_id}/delete', [ProductsController::class , 'delete'])->name('product.delete');

        Route::get('{product_id}/edit' , [ProductsController::class , 'edit'])->name('product.editPage');

        Route::put('{product_id}/update' , [ProductsController::class , 'update'])->name('product.update');
    });

    Route::prefix('users')->group(function () {

        route::get('/' , [UsersController::class , 'showAll'])->name('users.showAll');

        route::get('create' , [UsersController::class , 'showCreatePage'])->name('users.showCreatePage');

        route::post('store' , [UsersController::class , 'storeUser'])->name('users.storeNewUser');

        route::get('{user_id}/edit' , [UsersController::class , 'edit'])->name('users.showEditPage');

        route::put('{user_id}/update' , [UsersController::class , 'update'])->name('users.updateUser');

        route::delete('{user_id}/delete' , [UsersController::class , 'delete'])->name('users.deleteUser');

    });

});