<?php

use App\Http\Controllers\Dashboard\BrandsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\MainCategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\SubCategoriesController;
use App\Http\Controllers\Dashboard\TagsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/
//  all prefix -> admin
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    // AUTH ADMIN
    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('', [DashboardController::class, 'index'])->name('admin.dashboard');
        // LOGOUT
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
        // SHIPPING
        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', [SettingsController::class, 'editShippingMethods'])->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}', [SettingsController::class, 'updateShippingMethods'])->name('update.shipping.methods');
        });
        // PROFILE
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', [ProfileController::class, 'editProfile'])->name('edit.profile');
            Route::put('update', [ProfileController::class, 'updateProfile'])->name('update.profile');
        });

        // CATEGORIES
        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/', [MainCategoriesController::class, 'index'])->name('admin.maincategories');
            Route::get('create', [MainCategoriesController::class, 'create'])->name('admin.maincategories.create');
            Route::post('store', [MainCategoriesController::class, 'store'])->name('admin.maincategories.store');
            Route::get('edit/{id}', [MainCategoriesController::class, 'edit'])->name('admin.maincategories.edit');
            Route::post('update/{id}', [MainCategoriesController::class, 'update'])->name('admin.maincategories.update');
            Route::get('delete/{id}', [MainCategoriesController::class, 'destroy'])->name('admin.maincategories.delete');
        });
        // /CATEGORIES

        // CATEGORIES
        Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/', [SubCategoriesController::class, 'index'])->name('admin.subcategories');
            Route::get('create', [SubCategoriesController::class, 'create'])->name('admin.subcategories.create');
            Route::post('store', [SubCategoriesController::class, 'store'])->name('admin.subcategories.store');
            Route::get('edit/{id}', [SubCategoriesController::class, 'edit'])->name('admin.subcategories.edit');
            Route::post('update/{id}', [SubCategoriesController::class, 'update'])->name('admin.subcategories.update');
            Route::get('delete/{id}', [SubCategoriesController::class, 'destroy'])->name('admin.subcategories.delete');
        });
        // /CATEGORIES

        // brands
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/', [BrandsController::class, 'index'])->name('admin.brands');
            Route::get('create', [BrandsController::class, 'create'])->name('admin.brands.create');
            Route::post('store', [BrandsController::class, 'store'])->name('admin.brands.store');
            Route::get('edit/{id}', [BrandsController::class, 'edit'])->name('admin.brands.edit');
            Route::post('update/{id}', [BrandsController::class, 'update'])->name('admin.brands.update');
            Route::get('delete/{id}', [BrandsController::class, 'destroy'])->name('admin.brands.delete');
        });
        // /brands



        // tags
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', [TagsController::class, 'index'])->name('admin.tags');
            Route::get('create', [TagsController::class, 'create'])->name('admin.tags.create');
            Route::post('store', [TagsController::class, 'store'])->name('admin.tags.store');
            Route::get('edit/{id}', [TagsController::class, 'edit'])->name('admin.tags.edit');
            Route::post('update/{id}', [TagsController::class, 'update'])->name('admin.tags.update');
            Route::get('delete/{id}', [TagsController::class, 'destroy'])->name('admin.tags.delete');
        });
        // /tags


        // products
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products');
            Route::get('general-information', [ProductController::class, 'create'])->name('admin.products.general.create');
            Route::post('store', [ProductController::class, 'store'])->name('admin.products.store');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
            Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.delete');
        });
        // /products
    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'postLogin'])->name('admin.post.login');
    });


});

