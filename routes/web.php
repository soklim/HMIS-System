<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\GroupModuleController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get("/error404", function(){
    return View::make("error.error404");
});

Route::group(['middleware' => ['auth']], function() {

    Route::resource('products', ProductController::class);

    //User
    Route::resource('users', UserController::class);
    Route::get('/UserGetData',[UserController::class, 'getData'])->name('users.GetData');
    Route::get('/UserGetInitPage',[UserController::class, 'getInitPage'])->name('users.GetInitPage');
    Route::post('/UserSave',[UserController::class, 'Save'])->name('users.Save');
    Route::post('/UserUpdateActive',[UserController::class, 'Update'])->name('users.Update');
    Route::post('/ResetPassword',[UserController::class, 'ResetPassword'])->name('users.ResetPassword');

    //Role
    Route::resource('roles', RoleController::class);
    Route::get('/RoleGetData',[RoleController::class, 'getData'])->name('roles.GetData');
    Route::post('/RoleSave',[RoleController::class, 'Save'])->name('roles.Save');

    //Group Module
    Route::resource('group_modules', GroupModuleController::class);
    Route::get('/GroupModuleGetData',[GroupModuleController::class, 'getData'])->name('group_modules.GetData');
    Route::post('/GroupModuleSave',[GroupModuleController::class, 'Save'])->name('group_modules.Save');
});
