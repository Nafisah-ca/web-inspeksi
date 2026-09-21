<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Inspector;
use App\Http\Controllers\User;
use App\Http\Controllers\Admin\SiteContentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paket', [HomeController::class, 'packages'])->name('packages');

// Slot availability (AJAX)
Route::get('/booking/slots', [BookingController::class, 'getAvailableSlots'])->name('booking.slots');

/*
|--------------------------------------------------------------------------
| Auth Routes (Customer)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Booking Routes (Customer — requires auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/booking/create',    [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking',          [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}/success', [BookingController::class, 'success'])->name('booking.success');
});

/*
|--------------------------------------------------------------------------
| Customer Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

    // Booking history
    Route::get('/bookings',                    [User\BookingHistoryController::class, 'index'])->name('bookings');
    Route::get('/bookings/{booking}',          [User\BookingHistoryController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel',  [User\BookingHistoryController::class, 'cancel'])->name('bookings.cancel');

    // Profile
    Route::get('/profile',           [User\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile',           [User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',  [User\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Vehicles
    Route::post('/vehicles',             [User\ProfileController::class, 'storeVehicle'])->name('vehicles.store');
    Route::put('/vehicles/{vehicle}',    [User\ProfileController::class, 'updateVehicle'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [User\ProfileController::class, 'destroyVehicle'])->name('vehicles.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login',  [AdminLoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    /*
    |----------------------------------------------------------------------
    | Admin Panel (Protected)
    |----------------------------------------------------------------------
    */
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Bookings
        Route::get('/bookings',                            [Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create',                     [Admin\BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings',                           [Admin\BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/vehicles',                   [Admin\BookingController::class, 'getVehiclesByCustomer'])->name('bookings.vehicles');
        Route::get('/bookings/{booking}',                  [Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking}/confirm',         [Admin\BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/start',           [Admin\BookingController::class, 'startService'])->name('bookings.start');
        Route::post('/bookings/{booking}/complete',        [Admin\BookingController::class, 'complete'])->name('bookings.complete');
        Route::post('/bookings/{booking}/assign',          [Admin\BookingController::class, 'assignInspector'])->name('bookings.assign');
        Route::post('/bookings/{booking}/status',          [Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
        Route::post('/bookings/{booking}/cancel',          [Admin\BookingController::class, 'cancel'])->name('bookings.cancel');

        // Inspection Results (admin input / view)
        Route::get('/results',                             [Admin\InspectionResultController::class, 'index'])->name('results.index');
        Route::get('/bookings/{booking}/result/create',    [Admin\InspectionResultController::class, 'create'])->name('results.create');
        Route::post('/bookings/{booking}/result',          [Admin\InspectionResultController::class, 'store'])->name('results.store');
        Route::get('/bookings/{booking}/result',           [Admin\InspectionResultController::class, 'show'])->name('results.show');

        // Packages (CMS)
        Route::resource('packages', Admin\PackageController::class)->names('packages');

        // Checklist Items
        Route::get('/checklist',                           [Admin\ChecklistItemController::class, 'index'])->name('checklist.index');
        Route::post('/checklist',                          [Admin\ChecklistItemController::class, 'store'])->name('checklist.store');
        Route::put('/checklist/{checklistItem}',           [Admin\ChecklistItemController::class, 'update'])->name('checklist.update');
        Route::delete('/checklist/{checklistItem}',        [Admin\ChecklistItemController::class, 'destroy'])->name('checklist.destroy');

        // Inspectors (CMS)
        Route::resource('inspectors', Admin\InspectorController::class)->names('inspectors');

        // CMS Konten Website
        Route::get('/site-content',                        [SiteContentController::class, 'index'])->name('site-content.index');
        Route::get('/site-content/{section}/edit',         [SiteContentController::class, 'edit'])->name('site-content.edit');
        Route::put('/site-content/{section}',              [SiteContentController::class, 'update'])->name('site-content.update');
    });
});

/*
|--------------------------------------------------------------------------
| Inspector Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'inspector'])->prefix('inspector')->name('inspector.')->group(function () {
    Route::get('/dashboard',                      [Inspector\TaskController::class, 'dashboard'])->name('dashboard');
    Route::get('/tasks/{booking}',               [Inspector\TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{booking}/start',        [Inspector\TaskController::class, 'startWork'])->name('tasks.start');
    Route::post('/tasks/{booking}/result',       [Inspector\TaskController::class, 'submitResult'])->name('tasks.result');
});
