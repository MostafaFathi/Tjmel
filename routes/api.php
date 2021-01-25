<?php

use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['localization', 'auth:sanctum', 'throttle:api'], 'as' => 'api.'], function () {


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        /* one route calls */
        Route::get('/', [UserController::class, 'showUserProfile'])->name('show');
        Route::post('/', [UserController::class, 'updateUserProfile'])->name('update');
        Route::get('/reservations', [ReservationController::class, 'showUserReservations'])->name('reservations');
    });
    Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function () {
        /* one route calls */
        Route::get('/', [FavoriteController::class, 'showUserFavorites'])->name('index');
        Route::post('/', [FavoriteController::class, 'storeUserFavorite'])->name('store');
        Route::post('/remove', [FavoriteController::class, 'destroyUserFavorite'])->name('destroy');
    });
    Route::group(['prefix' => 'clinic', 'as' => 'clinic.'], function () {
        /* one route calls */
        Route::get('/rating', [ClinicController::class, 'showClinicsByRating'])->name('rating.order');
        Route::get('/location', [ClinicController::class, 'showClinicsByLocation'])->name('location.order');
        Route::get('/{id}', [ClinicController::class, 'showClinic'])->name('show');
        Route::post('/{id}/service/{service_id}/reserve', [ClinicController::class, 'reserveClinicService'])->name('reserve');
    });
    Route::group(['prefix' => 'offer', 'as' => 'offer.'], function () {
        /* one route calls */
        Route::get('/price', [OfferController::class, 'showOffersByPrice'])->name('price.order');
        Route::get('/location', [OfferController::class, 'showOffersByLocation'])->name('location.order');
    });
    Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
        /* one route calls */
        Route::get('/price', [ServiceController::class, 'showServicesByPrice'])->name('price.order');
        Route::get('/location', [ServiceController::class, 'showServicesByLocation'])->name('location.order');
    });

});

/* Start General routes */
Route::group(['as' => 'api.', 'middleware' => ['localization', 'throttle:api']], function () {
    /* one route calls */
    Route::post('/register/otp/send', [RegisterController::class, 'sendOtpCode'])->name('register.otp.send');
    Route::post('/login/otp/send', [LoginController::class, 'sendOtpCode'])->name('login.otp.send');
    Route::post('/user/otp/verify', [UserController::class, 'userVerifyOtpCode'])->name('user.otp.verify');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        /* one route calls */
        Route::get('/about_us', [SettingController::class, 'showAboutUs'])->name('about_us');
        Route::get('/agreement', [SettingController::class, 'showAgreement'])->name('agreement');
        Route::post('/contact_us', [SettingController::class, 'storeContactUs'])->name('contact_us');
        Route::get('/advertisements', [SettingController::class, 'getAdvertisement'])->name('advertisements');
        Route::get('/', [SettingController::class, 'showSettings'])->name('show');

    });
    /* redirect not logged-in users to unauthenticated route */
    Route::get('/unauthenticated', function () {
        return response()->json(['message' => 'unauthenticated', 'status' => false], 401);
    })->name('unauthenticated');
});
/* End General routes */

