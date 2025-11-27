<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WardReportController;
use App\Http\Controllers\ProvinceReportController;
use App\Http\Controllers\ViewSessionController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/sign', [LoginController::class, 'sign'])->name('sign');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['logins'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    Route::get('/index', [ImportExcelController::class, 'index'])->name('index');


    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    Route::get('/form-add-account', [AdminController::class, 'form_add_account'])->name('form.add-account');

    Route::get('/ajax/get-wards-admin', [AdminController::class, 'getWards'])->name('ajax.getWardsAdmin');
    Route::get('/ajax/province-codes-admin', [AdminController::class, 'getProvinceCode'])->name('ajax.getProvinceCodeAdmin');
    Route::get('/ajax/ward-code-admin', [AdminController::class, 'getWardCode'])->name('ajax.getWardCodeAdmin');

    Route::get('/ajax/province-codes-admin', [UserController::class, 'getProvinceCode'])->name('ajax.getProvinceCodeAdmin');
    Route::get('/ajax/ward-code-admin', [UserController::class, 'getWardCode'])->name('ajax.getWardCodeAdmin');

    
    Route::post('/register/admin/store', [AdminController::class, 'store'])->name('account.admin-store');
    Route::get('/form/edit-account/{id}', [AdminController::class, 'form_edit_account'])->name('form.edit-account');
    Route::delete('/delete-acount/{id}', [AdminController::class, 'delete'])->name('delete.account');


    Route::get('/view-ward-report', [WardReportController::class, 'view_ward_report'])->name('view.ward-report');

    Route::get('/view-session', [ViewSessionController::class, 'view_session'])->name('view.session');


    Route::group([
        'middleware' => 'checkWardProvince:1', 
    ], function () {
        Route::post('/import-excel-queue', [ImportExcelController::class, 'importQueue'])->name('import.excel');
    });

    Route::group([
        'middleware' => 'checkWardProvince:2', 
    ], function () {
        Route::post('/get-province', [ProvinceReportController::class, 'province'])->name('get.province');
        Route::get('/view-user', [UserController::class, 'view_user'])->middleware('checkWardProvince:2')->name('view.user');
        Route::get('/form-add-user', [UserController::class, 'form_add_user'])->middleware('checkWardProvince:2')->name('form.add-user');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');


        Route::get('/ajax/get-wards', [UserController::class, 'getWards'])->name('ajax.getWards');

        Route::get('/ajax/province-codes', [UserController::class, 'getProvinceCode'])->name('ajax.getProvinceCodeUser');
        Route::get('/ajax/ward-code', [UserController::class, 'getWardCode'])->name('ajax.getWardCodeUser');

        Route::get('/form/{id}/edit-user', [UserController::class, 'form_edit_user'])->middleware('checkWardProvince:2')->name('form.edit-user');
        Route::put('/form/update-user/{id}', [UserController::class, 'update'])->middleware('checkWardProvince:2')->name('form.update-user');
        Route::delete('/delete-user/{id}', [UserController::class, 'delete'])->name('delete.user');


        Route::get('/view-province-report', [ProvinceReportController::class, 'view_province_report'])->middleware('checkWardProvince:2')->name('view.province-report');
        Route::get('/export-provinces', [ProvinceReportController::class, 'export'])->middleware('checkWardProvince:2')->name('export.province-report');
        Route::delete('/delete-province-report/{province_report_id}', [ProvinceReportController::class, 'delete'])->middleware('checkWardProvince:2')->name('delete.province-report');

        Route::get('/view-ward-report', [WardReportController::class, 'view_ward_report'])->middleware('checkWardProvince:2')->name('view.ward-report');
        Route::delete('/delete-ward-report/{ward_report_id}', [WardReportController::class, 'delete'])->middleware('checkWardProvince:2')->name('delete.ward-report');
        Route::get('/export-wards', [WardReportController::class, 'export'])->middleware('checkWardProvince:2')->name('export.ward-report');
        
    });

});