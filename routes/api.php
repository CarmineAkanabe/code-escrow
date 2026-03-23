<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


/**
    * EXTERNAL PUBLIC ROUTES
*/

// This is to test the API routes
Route::get('/ping', function () {
    return response()->json(['message' => 'API is alive']);
});

// Users Register through this route
Route::post('/register', [AuthController::class, 'register']);

// Users Login/Authenticate through this route
Route::post('/login', [AuthController::class, 'login']);

/**
 * ROUTES UNDER MIDDLEWARE PROTECTION (REQUIRE AUTHENTICATION)
 */

Route::middleware('auth:sanctum')->group( function () {

    // This route is for Loging out of the system
    Route::post('/logout', [AuthController::class, 'logout']);
    

    // This is to display all the needed info (userwise)
    Route::get('/gigs', [GigController::class, 'index']);
    // This is to store a gig
    Route::post('/gigs', [GigController::class, 'store']);


    // This route is to get all Freelancers
    Route::get('/freelancer', [FreelancerController::class, 'index']);
    // This is to add a new freelancer
    Route::post('/freelancer', [FreelancerController::class, 'store']);
    // This updates all trust scores of freelancers
    Route::patch('/freelancer/refresh-trust', [FreelancerController::class, 'refreshTrust']);


    // This is to get all the database transactions
    Route::get('/transaction', [TransactionController::class, 'index']);
    // This is to finalize a transaction
    Route::patch('/transaction/{transaction}/release', [TransactionController::class, 'release']);
});
