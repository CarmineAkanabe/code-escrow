<?php

use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// This is to test the API routes
Route::get('/ping', function () {
    return response()->json(['message' => 'API is alive']);
});

// This is to display all the needed info (userwise)
Route::get('/gigs', [GigController::class, 'index']);

// This is to store a gig
Route::post('/gigs', [GigController::class, 'store']);

// This route is to get all Freelancers
Route::get('/freelancer', [FreelancerController::class, 'index']);

// This is to add a new freelancer
Route::post('/freelancer', [FreelancerController::class, 'store']);

// This is to get all the database transactions
Route::get('/transaction', [TransactionController::class, 'index']);

// This updates all trust scores of freelancers
Route::patch('/freelancer/refresh-trust', [FreelancerController::class, 'refreshTrust']);

// This is to finalize a transaction
Route::patch('/transaction/{transaction}/release', [TransactionController::class, 'release']);