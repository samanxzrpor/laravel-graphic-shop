<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductsController as Shop;
use App\Http\Controllers\Shop\Cart;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\PaymentsController as Pay;
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


Route::prefix('')->group(function (){

    Route::get('' , [HomeController::class , 'index'])->name('homePage');

    Route::get('shop' , [Shop::class , 'showAll'])->name('shopPage');

    Route::get('shop/{product_id}/show' , [Shop::class , 'single'])->name('product.single');

    Route::prefix('cart')->group(function (){

        Route::get('' , [Cart::class , 'showAll'])->name('cart.showAll');

        Route::get('{product_id}/add' , [Cart::class , 'add'])->name('cart.add');

        Route::get('{product_id}/delete' , [Cart::class , 'delete'])->name('cart.delete');

    });

    Route::prefix('checkout')->group(function (){
        
        Route::get('' , [CheckoutController::class , 'show'])->name('checkout.show');

    });

});


Route::prefix('admin')->group(function () {

    Route::get('', function () {
        return view('admin.dashbord');
    })->name('admin');

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

    Route::prefix('orders')->group(function() {

        Route::get('/' , [OrdersController::class , 'showAll'])->name('orders.showAll');

    });

    Route::prefix('payments')->group(function() {

        Route::get('/' , [PaymentsController::class , 'showAll'])->name('payments.showAll');

    });


});

Route::prefix('payment')->group(function (){

    Route::post('pay' , [Pay::class , 'pay'])->name('payment.pay');

    Route::get('challback' , [Pay::class , 'challback'])->name('payment.callback');
});