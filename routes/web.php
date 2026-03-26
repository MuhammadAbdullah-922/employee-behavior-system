<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where all web routes are registered. Routes are grouped
| based on roles: Admin, Supervisor, Manager, Employee.
|
*/

// Redirect root to dashboard if authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// All routes require authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {

    // Common dashboard route for all roles
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile management (all users)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    | Admin has full access to Employees, Branches, Interactions, and Feedbacks
    */
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('interactions', InteractionController::class);
        Route::resource('feedbacks', FeedbackController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | SUPERVISOR ROUTES
    |--------------------------------------------------------------------------
    | Supervisor can view interactions and feedbacks, and create/store feedback for employees
    */
    Route::middleware(['role:Supervisor'])->group(function () {
        Route::resource('interactions', InteractionController::class)->only(['index', 'show']);
        Route::resource('feedbacks', FeedbackController::class)->only(['index', 'show', 'create', 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | MANAGER ROUTES
    |--------------------------------------------------------------------------
    | Manager has limited access: view only interactions and feedbacks
    */
    Route::middleware(['role:Manager'])->group(function () {
        Route::resource('interactions', InteractionController::class)->only(['index', 'show']);
        Route::resource('feedbacks', FeedbackController::class)->only(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | EMPLOYEE ROUTES
    |--------------------------------------------------------------------------
    | Employees can only give feedback for assigned interactions
    */
    Route::middleware(['role:Employee'])->group(function () {
        Route::get('/feedback/{interaction_id}', [FeedbackController::class, 'createCustomerFeedback'])
            ->name('feedback.customer.create');

        Route::post('/feedback/{interaction_id}', [FeedbackController::class, 'storeCustomerFeedback'])
            ->name('feedback.customer.store');
    });
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';