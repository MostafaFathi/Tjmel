<?php

use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceOfferController;
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
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});
Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
});
Route::get('/seed', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed');
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
        Route::resources(['contact_us' => ContactUsController::class]);
        Route::resources(['settings' => SettingController::class]);
        Route::resources(['clinics' => ClinicController::class]);
        Route::resources(['sections' => SectionController::class]);

        /* one route calls */
        Route::get('/city/districts/{id}', [SettingController::class, 'cityDistricts'])->name('city.districts');
        Route::post('/clinics/image/delete/{id}', [ClinicController::class, 'destroyClinicImage'])->name('products.image.destroy');

        //start admin services and offers
        Route::get('/services/acceptance', [ServiceOfferController::class, 'services'])->name('services.acceptance');
        Route::get('/services/show/{id}', [ServiceOfferController::class, 'showService'])->name('admin.services.show');
        Route::get('/offers/acceptance', [ServiceOfferController::class, 'offers'])->name('offers.acceptance');
        Route::get('/offers/show/{id}', [ServiceOfferController::class, 'showOffer'])->name('admin.offers.show');
        Route::post('/clinics/services/approve/{id}', [ServiceOfferController::class, 'changeServiceStatus']);
        Route::post('/clinics/offers/approve/{id}', [ServiceOfferController::class, 'changeOfferStatus']);
        Route::delete('/clinics/rates/delete/{id}', [ServiceOfferController::class, 'deleteRate']);
        //end admin services and offers

    });
    Route::group(['middleware' => ['role:admin|agent']], function () {
        /* Resources calls */
        Route::resources(['categories' => CategoryController::class]);
        Route::resources(['subcategories' => SubCategoryController::class]);
        Route::resources(['products' => ProductController::class]);
        Route::resources(['orders' => OrderController::class]);
        /* one route calls */
        Route::get('/orders/{order}/processing', [OrderController::class, 'processing'])->name('orders.processing');
        Route::get('/orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::get('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::post('/orders/delivery/{order}', [OrderController::class, 'delivery'])->name('orders.delivery');
        Route::post('/orders/redirect/{order}', [OrderController::class, 'redirect'])->name('orders.redirect');

        Route::get('/categories/{category}/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
        Route::get('/categories/{category}/activate', [CategoryController::class, 'activate'])->name('categories.activate');
        Route::get('/categories/subcategories/{id}', [CategoryController::class, 'subcategories'])->name('categories.subcategories');
        Route::get('/subcategories/{subcategory}/activate', [SubCategoryController::class, 'activate'])->name('subcategories.activate');

        Route::post('/products/image/delete/{id}', [ProductController::class, 'destroyProductImage'])->name('products.image.destroy');

    });
    /* End Dashboard management routes */

    /* Start Dashboard general routes */
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/telescope_view', [HomeController::class, 'telescope'])->name('telescope_view');
    Route::get('/logout', [HomeController::class, 'logout'])->name('log_out');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    /* End Dashboard general routes */
});
Route::get('/order', [OrderController::class, 'viewOrder'])->name('viewOrder');
Route::post('/order/callback', [OrderController::class, 'callback'])->name('order.callback');
Route::get('/order/orderSuccess', [OrderController::class, 'orderSuccess'])->name('order.orderSuccess');
