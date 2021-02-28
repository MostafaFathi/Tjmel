<?php

use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceOfferController;
use App\Http\Controllers\Admin\TipController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserGroupsController;
use App\Http\Controllers\Admin\UserGroupsPermissionsController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\ContactUsController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('landing.page');
Route::get('/storage/link', function () {
    dd(\Illuminate\Support\Facades\Artisan::call('storage:link'));
});
Route::get('/migrate', function () {
    dd(\Illuminate\Support\Facades\Artisan::call('migrate'));
});
Route::get('/seed', function () {
    dd(\Illuminate\Support\Facades\Artisan::call('db:seed'));
});
Route::get('/config/clear', function () {
    dd(\Illuminate\Support\Facades\Artisan::call('config:clear'));
});
Route::get('/time/now', function () {
    dd(\Carbon\Carbon::now());
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

    /* Start Dashboard management routes */
    Route::group(['middleware' => ['role:admin']], function () {
        /* Resources calls */
        Route::resources(['users' => UserController::class]);
        Route::resources(['users_groups' => UserGroupsController::class]);
        Route::resources(['users_groups_permissions' => UserGroupsPermissionsController::class]);
        Route::resources(['advertisements' => AdvertisementController::class]);
        Route::resources(['about_us' => AboutUsController::class]);
        Route::resources(['agreement' => AgreementController::class]);
        Route::resources(['contact_us' => ContactUsController::class]);
        Route::resources(['settings' => SettingController::class]);
        Route::resources(['clinics' => ClinicController::class]);
        Route::resources(['sections' => SectionController::class]);
        Route::resources(['tips' => TipController::class]);

        /* one route calls */
        Route::get('/city/districts/{id}', [SettingController::class, 'cityDistricts'])->name('city.districts');
        Route::post('/clinics/image/delete/{id}', [ClinicController::class, 'destroyClinicImage'])->name('products.image.destroy');
        Route::get('/applications', [ClinicController::class, 'clinicRequestsIndex'])->name('applications.index');

        //start admin services and offers
        Route::get('/services/acceptance', [ServiceOfferController::class, 'services'])->name('services.acceptance');
        Route::get('/services/show/{id}', [ServiceOfferController::class, 'showService'])->name('admin.services.show');
        Route::get('/offers/acceptance', [ServiceOfferController::class, 'offers'])->name('offers.acceptance');
        Route::get('/offers/show/{id}', [ServiceOfferController::class, 'showOffer'])->name('admin.offers.show');
        Route::put('/offers/update/{id}', [ServiceOfferController::class, 'updateOffer'])->name('admin.offers.update');
        Route::post('/clinics/services/approve/{id}', [ServiceOfferController::class, 'changeServiceStatus']);
        Route::post('/clinics/offers/approve/{id}', [ServiceOfferController::class, 'changeOfferStatus']);
        Route::delete('/clinics/rates/delete/{id}', [ServiceOfferController::class, 'deleteRate']);
        //end admin services and offers

    });

    /* End Dashboard management routes */

    /* Start Dashboard general routes */
    Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/telescope_view', [HomeController::class, 'telescope'])->name('telescope_view');
    Route::get('/logout', [HomeController::class, 'logout'])->name('log_out');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    /* End Dashboard general routes */

    Route::get('/git/stash', function () {
        dd(shell_exec('cd .. && git stash'));
    });
    Route::get('/git/reset', function () {
        dd(shell_exec('cd .. && git reset --hard'));
    });
    Route::get('/git/pull', function () {
        dd(shell_exec('cd .. && git pull origin main'));
    });

});
