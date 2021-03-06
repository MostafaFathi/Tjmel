<?php

use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserAddressController;
use App\Http\Controllers\Payment\PaymentController;
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

Route::group(['middleware' => ['localization', 'auth:sanctum','blocked','throttle:api'], 'as' => 'api.'], function () {


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        /* one route calls */
        Route::get('/', [UserController::class, 'showUserProfile'])->name('show');
        Route::post('/', [UserController::class, 'updateUserProfile'])->name('update');
        Route::get('/reservations', [ReservationController::class, 'showUserReservations'])->name('reservations');
        Route::get('/wallet', [UserController::class, 'getUserWallet'])->name('wallet');
        Route::group(['prefix' => 'address', 'as' => 'address.'], function () {
            /* one route calls */
            Route::get('/', [UserAddressController::class, 'showUserAddresses'])->name('show');
            Route::post('/', [UserAddressController::class, 'storeUserAddress'])->name('store');
            Route::post('/{id}', [UserAddressController::class, 'updateUserAddress'])->name('update');
            Route::delete('/{id}', [UserAddressController::class, 'destroyUserAddress'])->name('destroy');
            Route::post('/{id}/current', [UserAddressController::class, 'makeUserAddressAsCurrent'])->name('current');
        });
    });
    Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function () {
        /* one route calls */
        Route::get('/', [FavoriteController::class, 'showUserFavorites'])->name('index');
        Route::post('/', [FavoriteController::class, 'storeUserFavorite'])->name('store');
        Route::post('/remove', [FavoriteController::class, 'destroyUserFavorite'])->name('destroy');
        Route::post('/offer', [FavoriteController::class, 'storeOfferFavorite'])->name('offer.store');
        Route::post('/offer/remove', [FavoriteController::class, 'destroyOfferFavorite'])->name('offer.destroy');
    });
    Route::group(['prefix' => 'clinic', 'as' => 'clinic.'], function () {
        /* one route calls */
        Route::get('/rating', [ClinicController::class, 'showClinicsByRating'])->name('rating.order');
        Route::get('/location', [ClinicController::class, 'showClinicsByLocation'])->name('location.order');
        Route::get('/search', [ClinicController::class, 'searchClinics'])->name('search');
        Route::get('/{id}', [ClinicController::class, 'showClinic'])->name('show');
        Route::post('/{id}/rate', [ClinicController::class, 'rateClinic'])->name('rate');
        Route::post('/{id}/service/{service_id}/reserve', [ClinicController::class, 'reserveClinicService'])->name('service.reserve');
        Route::post('/{id}/offer/{offer_id}/reserve', [ClinicController::class, 'reserveClinicOffer'])->name('offer.reserve');
    });
    Route::group(['prefix' => 'reserve', 'as' => 'reserve.'], function () {
        /* one route calls */
        Route::post('/{id}/cancel', [ReservationController::class, 'cancelReserve'])->name('cancel');
        Route::get('/{id}/save', [ReservationController::class, 'saveReserve'])->name('save');
        Route::get('/{reserveId}/wallet/pay', [PaymentController::class, 'useWalletToReserve'])->name('wallet.pay');
    });
    Route::group(['prefix' => 'offer', 'as' => 'offer.'], function () {
        /* one route calls */
        Route::get('/price', [OfferController::class, 'showOffersByPrice'])->name('price.order');
        Route::get('/location', [OfferController::class, 'showOffersByLocation'])->name('location.order');
        Route::get('/{id}', [OfferController::class, 'showOffer'])->name('show');
    });
    Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
        /* one route calls */
        Route::get('/price', [ServiceController::class, 'showServicesByPrice'])->name('price.order');
        Route::get('/location', [ServiceController::class, 'showServicesByLocation'])->name('location.order');
        Route::get('/{id}', [ServiceController::class, 'showService'])->name('show');
    });

});

/* Start General routes */
Route::group(['as' => 'api.', 'middleware' => ['localization', 'throttle:api']], function () {
    /* one route calls */
    Route::post('/register/otp/send', [RegisterController::class, 'sendOtpCode'])->name('register.otp.send');
    Route::post('/login/otp/send', [LoginController::class, 'sendOtpCode'])->name('login.otp.send');
    Route::post('/user/otp/verify', [UserController::class, 'userVerifyOtpCode'])->name('user.otp.verify');
    Route::post('/clinic/application', [ClinicController::class, 'storeClinicRequest'])->name('application.store');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        /* one route calls */
        Route::get('/about_us', [SettingController::class, 'showAboutUs'])->name('about_us');
        Route::get('/agreement', [SettingController::class, 'showAgreement'])->name('agreement');
        Route::post('/contact_us', [SettingController::class, 'storeContactUs'])->name('contact_us');
        Route::get('/advertisements', [SettingController::class, 'getAdvertisement'])->name('advertisements');
        Route::get('/sections', [SettingController::class, 'showSections'])->name('sections');
        Route::get('/', [SettingController::class, 'showSettings'])->name('show');
        Route::get('/cities', [SettingController::class, 'showCities'])->name('cities.show');

    });
    /* redirect not logged-in users to unauthenticated route */
    Route::get('/unauthenticated', function () {
        return response()->json(['message' => 'unauthenticated', 'status' => false], 401);
    })->name('unauthenticated');
});
/* End General routes */

