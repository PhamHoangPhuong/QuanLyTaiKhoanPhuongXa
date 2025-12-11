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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChartWardHomeController;
use App\Http\Controllers\ChartWardController;
use App\Http\Controllers\ChartProvinceHomeController;
use App\Http\Controllers\ChartProvinceController;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/sign', [LoginController::class, 'sign'])->name('sign');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


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

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    

    Route::get('/view-ward-report', [WardReportController::class, 'view_ward_report'])->name('view.ward-report');

    Route::get('/view-session', [ViewSessionController::class, 'view_session'])->name('view.session');


    Route::group([
        'middleware' => 'checkWardProvince:1', 
    ], function () {
        Route::post('/import-excel-queue', [ImportExcelController::class, 'importQueue'])->middleware('checkWardProvince:1')->name('import.excel');
        Route::get('/change-ward-password/form/{id}', [AccountController::class, 'change_ward_password_form'])->middleware('checkWardProvince:1')->name('change.ward-password.form');
        Route::put('/change-ward-password/update/{id}', [AccountController::class, 'change_ward_password_update'])->middleware('checkWardProvince:1')->name('change.ward-password.update');

        Route::get('/chart-ward', [ChartWardController::class, 'chart_ward'])->name('chart.ward');

        Route::get('/chart-ward-data-column-home', [ChartWardHomeController::class, 'chartWardDataColumnHome'])->name('chart.ward-data-column-home');

        Route::get('/chart-ward-data-circle-home', [ChartWardHomeController::class, 'chartWardDataCircleHome'])->name('chart.ward-data-circle-home');

        Route::get('/chart-ward-data-column', [ChartWardController::class, 'chartWardDataColumn'])->name('chart.ward-data-column');
        Route::get('/chart-ward-data-circle', [ChartWardController::class, 'chartWardDataCircle'])->name('chart.ward-data-circle');
        Route::get('/chart-ward-data-circle-1', [ChartWardController::class, 'chartWardDataCircle_1'])->name('chart.ward-data-circle_1');
        Route::get('/chart-ward-data-circle-2', [ChartWardController::class, 'chartWardDataCircle_2'])->name('chart.ward-data-circle_2');
        Route::get('/chart-ward-data-circle-3', [ChartWardController::class, 'chartWardDataCircle_3'])->name('chart.ward-data-circle_3');

        Route::get('/years-ward-column-home', [ChartWardHomeController::class, 'getYearsWardColumnHome']);

        Route::get('/years-ward-circle-home', [ChartWardHomeController::class, 'getYearsWardCircleHome']);


        //Non home

        Route::get('/api/get-years-ward', [ChartWardController::class,'getYearsByWard']);
    });

    Route::group([
        'middleware' => 'checkWardProvince:2', 
    ], function () {
        Route::post('/get-province', [ProvinceReportController::class, 'province'])->name('get.province');
        Route::get('/view-user', [UserController::class, 'view_user'])->middleware('checkWardProvince:2')->name('view.user');
        Route::get('/form-add-user', [UserController::class, 'form_add_user'])->middleware('checkWardProvince:2')->name('form.add-user');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

        Route::get('/change-province-password/form/{id}', [AccountController::class, 'change_province_password_form'])->middleware('checkWardProvince:2')->name('change.province-password.form');
        Route::put('/change-province-password/update/{id}', [AccountController::class, 'change_province_password_update'])->middleware('checkWardProvince:2')->name('change.province-password.update');

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

        Route::get('/chart-province', [ChartProvinceController::class, 'chart_province'])->name('chart.province');

        Route::get('/chart-province-data-column-home', [ChartProvinceHomeController::class, 'chartProvinceDataColumnHome'])->name('chart.province-data-column-home');

        Route::get('/chart-province-data-circle-home', [ChartProvinceHomeController::class, 'chartProvinceDataCircleHome'])->name('chart.province-data-circle-home');

        Route::get('/chart-province-data-column', [ChartProvinceController::class, 'chartProvinceDataColumn'])->name('chart.province-data-column');
        Route::get('/chart-province-data-circle', [ChartProvinceController::class, 'chartProvinceDataCircle'])->name('chart.province-data-circle');
        Route::get('/chart-province-data-circle-1', [ChartProvinceController::class, 'chartProvinceDataCircle_1'])->name('chart.province-data-circle_1');
        Route::get('/chart-province-data-circle-2', [ChartProvinceController::class, 'chartProvinceDataCircle_2'])->name('chart.province-data-circle_2');
        Route::get('/chart-province-data-circle-3', [ChartProvinceController::class, 'chartProvinceDataCircle_3'])->name('chart.province-data-circle_3');

        Route::get('/years-province-column-home', [ChartProvinceHomeController::class, 'getYearsProvinceColumnHome']);

        Route::get('/years-province-circle-home', [ChartProvinceHomeController::class, 'getYearsProvinceCircleHome']);

        //Non home

        Route::get('/api/get-years-province', [ChartProvinceController::class,'getYearsByProvince']);
        
    });

    Route::group([
        'middleware' => 'checkWardProvince:3', 
    ], function () {
        Route::post('/register/admin/store', [AdminController::class, 'store'])->name('account.admin-store');
        Route::get('/form/edit-account/{id}', [AdminController::class, 'form_edit_account'])->name('form.edit-account');
        Route::put('/form/update-account/{id}', [AdminController::class, 'update'])->name('form.update-account');
        Route::delete('/delete-acount/{id}', [AdminController::class, 'delete'])->name('delete.account');
        
    });

});