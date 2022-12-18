<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\GroupModuleController;
use App\Http\Controllers\EMRDeathController;
use App\Http\Controllers\EMRBirthController;
use App\Http\Controllers\SettingTypeController;
use App\Http\Controllers\SettingItemController;
use App\Http\Controllers\ModulePermissionController;
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
    Route::post('/UserGetDistrict',[UserController::class, 'getDistrict'])->name('users.getDistrict');
    Route::post('/UserGetHF',[UserController::class, 'getHF'])->name('users.getHF');
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

    //Module
    Route::resource('modules', ModuleController::class);
    Route::get('/ModuleGetData',[ModuleController::class, 'getData'])->name('modules.GetData');
    Route::post('/ModuleSave',[ModuleController::class, 'Save'])->name('modules.Save');

    //Permission
    Route::resource('module_permissions', ModulePermissionController::class);
    Route::get('/PermissionGetData',[ModulePermissionController::class, 'getData'])->name('module_permissions.GetData');
    Route::post('/PermissionSave',[ModulePermissionController::class, 'Save'])->name('module_permissions.Save');

    //Setting Type
    Route::resource('setting_types', SettingTypeController::class);
    Route::get('/SettingTypeGetData',[SettingTypeController::class, 'getData'])->name('setting_types.GetData');
    Route::post('/SettingTypeSave',[SettingTypeController::class, 'Save'])->name('setting_types.Save');


    //Setting Item
    Route::resource('setting_items', SettingItemController::class);
    Route::get('/SettingItemGetData',[SettingItemController::class, 'getData'])->name('setting_items.GetData');
    Route::post('/SettingItemSave',[SettingItemController::class, 'Save'])->name('setting_items.Save');

    //Death Notification
    Route::resource('emr_death', EMRDeathController::class);
    Route::get('/EMRDeath_GetData',[EMRDeathController::class, 'getData'])->name('emr_death.GetData');
    Route::get('/EMRDeath_GetInitPage',[EMRDeathController::class, 'getInitPage'])->name('emr_death.GetInitPage');
    Route::post('/EMRDeath_GetDistrict',[EMRDeathController::class, 'getDistrict'])->name('emr_death.getDistrict');
    Route::post('/EMRDeath_GetCommune',[EMRDeathController::class, 'getCommune'])->name('emr_death.getCommune');
    Route::post('/EMRDeath_GetVillage',[EMRDeathController::class, 'getVillage'])->name('emr_death.getVillage');
    Route::post('/EMRDeathSave',[EMRDeathController::class, 'Save'])->name('emr_death.Save');
    Route::get('/emr_death_print', [EMRDeathController::class, 'Print'])->name('emr_print.Print');

    //Birth Notification
    Route::resource('emr_birth', EMRBirthController::class);
    Route::get('/Birth_GetData',[EMRBirthController::class, 'getData'])->name('emr_birth.GetData');
    Route::post('/Birth_GetDistrict',[EMRBirthController::class, 'getDistrict'])->name('emr_birth.getDistrict');
    Route::post('/Birth_GetCommune',[EMRBirthController::class, 'getCommune'])->name('emr_birth.getCommune');
    Route::post('/Birth_GetVillage',[EMRBirthController::class, 'getVillage'])->name('emr_birth.getVillage');
    Route::post('/BirthSave',[EMRBirthController::class, 'Save'])->name('emr_birth.Save');
    Route::get('/BirthPrint', [EMRBirthController::class, 'Print'])->name('emr_birth.Print');
});
