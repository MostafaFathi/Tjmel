<?php

use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceOfferController;
use App\Http\Controllers\Clinic\AppointmentController;
use App\Http\Controllers\Clinic\OfferController;
use App\Http\Controllers\Clinic\ReservationController;
use App\Http\Controllers\Clinic\ServiceController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserGroupsController;
use App\Http\Controllers\Admin\UserGroupsPermissionsController;
use App\Http\Controllers\Admin\AdvertisementController;

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ContactUsController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Clinic\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'clinic', 'middleware' => ['auth']], function () {

    /* Start Dashboard management routes */
    Route::group(['middleware' => ['role:clinic']], function () {
        /* Resources calls */

        Route::resources(['services' => ServiceController::class]);
        Route::resources(['offers' => OfferController::class]);
        Route::resources(['appointments' => AppointmentController::class]);
        Route::resources(['reservations' => ReservationController::class]);

        /* one route calls */
        Route::get('/appointments/date/{month}/{id?}', [AppointmentController::class, 'getDate'])->name('appointments.date');
        Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
    });

    /* End Dashboard management routes */

    /* Start Dashboard general routes */
    /* End Dashboard general routes */


});
