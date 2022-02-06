<?php

use App\Http\Controllers\Api\ApiKeranjangController;
use App\Http\Controllers\Api\ApiPemesananController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiBannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API PRODUCT
Route::get('product-list',[ApiProductController::class, 'getProducts']);
Route::get('best-product',[ApiProductController::class, 'bestProducts']);
Route::get('detail-product/{id}',[ApiProductController::class, 'productDetail']);
Route::get('search-product',[ApiProductController::class, 'searchProduct']);

// API KERANJANG
Route::get('keranjang-list',[ApiKeranjangController::class, 'getKeranjangs']);
Route::post('keranjang-post',[ApiKeranjangController::class, 'postKeranjang']);
Route::post('keranjang-delete',[ApiKeranjangController::class, 'deleteKeranjang']);

// API PEMESANAN
//           routing          file controller                fungsi yg ada di controller
Route::post('pemesanan-post',[ApiPemesananController::class, 'postPemesanan']);

// API BANNER
Route::get('banner-list',[ApiBannerController::class, 'getBanners']);
