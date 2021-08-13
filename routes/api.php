<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ExamController;



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

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/exam', [ExamController::class, 'store']);


Route::group(['middleware' => ['auth:api']], function(){


    Route::patch('/products/{product}', [ProductController::class, 'update']);

    Route::post('/products', [ProductController::class, 'store']);
    
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    
    //Review Route
    Route::group(['prefix' => 'products'], function(){

    Route::post('/{product}/reviews', [ReviewController::class, 'store']);

    Route::patch('/{product}/reviews/{review}', [ReviewController::class, 'update']);

    Route::delete('/{product}/reviews/{review}', [ReviewController::class, 'destroy']);

    });
});    


//Review Route
Route::group(['prefix' => 'products'], function(){

    Route::get('/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
});







