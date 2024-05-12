<?php

use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\UserController;
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

Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware('login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('login');
Route::get('/', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');

Route::group(['middleware' => ['admin', 'locale']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'user/'], function () {
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('delete/{id}', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
        Route::delete('destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::group(['prefix' => 'user/catalogue/'], function () {
        Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
        Route::get('edit/{id}', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
        Route::post('update/{id}', [UserCatalogueController::class, 'update'])->name('user.catalogue.update');
        Route::get('delete/{id}', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
        Route::delete('destroy/{id}', [UserCatalogueController::class, 'destroy'])->name('user.catalogue.destroy');
        Route::get('permission', [UserCatalogueController::class, 'permission'])->name('user.catalogue.permission');
        Route::post('updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('user.catalogue.updatePermission');


    });

    Route::group(['prefix' => 'language/'], function () {
        Route::get('index', [LanguageController::class, 'index'])->name('language.index');
        Route::get('switch/{id}', [LanguageController::class, 'swicthBackendLanguage'])->name('language.switch');
        Route::get('create', [LanguageController::class, 'create'])->name('language.create');
        Route::post('store', [LanguageController::class, 'store'])->name('language.store');
        Route::get('edit/{id}', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('language.edit');
        Route::post('update/{id}', [LanguageController::class, 'update'])->name('language.update');
        Route::get('delete/{id}', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('language.delete');
        Route::delete('destroy/{id}', [LanguageController::class, 'destroy'])->name('language.destroy');
    });

    Route::group(['prefix' => 'permission/'], function () {
        Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('permission.edit');
        Route::post('update/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::get('delete/{id}', [PermissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('permission.delete');
        Route::delete('destroy/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    Route::group(['prefix' => 'post/catalogue/'], function () {
        Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
        Route::get('edit/{id}', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
        Route::post('update/{id}', [PostCatalogueController::class, 'update'])->name('post.catalogue.update');
        Route::get('delete/{id}', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
        Route::delete('destroy/{id}', [PostCatalogueController::class, 'destroy'])->name('post.catalogue.destroy');
    });

    Route::group(['prefix' => 'post/'], function () {
        Route::get('index', [PostController::class, 'index'])->name('post.index');
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('store', [PostController::class, 'store'])->name('post.store');
        Route::get('edit/{id}', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
        Route::post('update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('delete/{id}', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
        Route::delete('destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    });
// AJAX
    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.getLocation');

    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');

});
