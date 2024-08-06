<?php

use App\Http\Controllers\SaveParcedReviewsController;
use App\Http\Controllers\SaveRequestController;
use App\Http\Services\Craigslist\CraigslistServices;
use App\Http\Services\PostScheduled\PostScheduledServices;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('/store-request-data', [SaveRequestController::class, 'storeRequestData']);

Route::post('/save-parced-reviews-data', [SaveParcedReviewsController::class, 'saveParcedReviewsData']);

Route::redirect('', '/admin')->name('login');


Route::get('/pupupu_test', function () {
    // (new PostScheduledServices)->scheduler();
    dd((new CraigslistServices)->createAPI(1));
    return 1;
});
