<?php

use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/subscriptions', [SubscriptionController::class, 'list'])->name('subscriptions');
    Route::post('/packages', [PackagesController::class, 'store'])->name('packages.store');
    Route::post('/customers', [SubscriptionController::class, 'storeCustomer'])->name('customers.store');
    Route::get('/stripe', [StripePaymentController::class, 'stripe'])->name('stripe.view');
    Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
});

require __DIR__.'/auth.php';
