<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;

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

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    // API route for CRUD property (kos)
    Route::resource('property', App\Http\Controllers\API\PropertyController::class);

    // API route for ask available property (kos)
    Route::post('askavailability', [App\Http\Controllers\API\AskAvailabilityController::class, 'store']);

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

// API route for search property
Route::get('/search', [App\Http\Controllers\API\SearchController::class, 'index']);

// API route for detail property
Route::get('/detail/{id}', [App\Http\Controllers\API\SearchController::class, 'show']);
