<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| ROOT ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGGED IN USERS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |-----------------------
    | DASHBOARD
    |-----------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |-----------------------
    | PROFILE
    |-----------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware(['role:Admin'])->group(function () {

        Route::resource('employees', EmployeeController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('interactions', InteractionController::class);

        // Admin feedback management
        Route::resource('feedbacks', FeedbackController::class);
    });


    /*
    |--------------------------------------------------------------------------
    | PUBLIC QR FEEDBACK ROUTES (CUSTOMER - NO LOGIN REQUIRED)
    |--------------------------------------------------------------------------
    */

    Route::get('/feedback/{interaction_id}', [FeedbackController::class, 'createCustomerFeedback'])
        ->name('feedback.customer.create');

    Route::post('/feedback/{interaction_id}', [FeedbackController::class, 'storeCustomerFeedback'])
        ->name('feedback.customer.store');

});

/*
|--------------------------------------------------------------------------
| AUTH FILE (Breeze / Jetstream etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';