<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotaryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotarySlotController;
use App\Http\Controllers\NotaryBookingController;
// Faqja kryesore dhe noterët (publike)
Route::get('/', [NotaryController::class, 'index'])->name('home');
Route::get('/notaries', [NotaryController::class, 'index'])->name('notaries.index');
Route::get('/notaries/{id}', [NotaryController::class, 'show'])->name('notaries.show');

// Faqja e suksesit të rezervimit (publike)
Route::get('/bookings/success', [BookingController::class, 'success'])->name('bookings.success');

// Autentikimi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rrugët për përdorues të kyçur
Route::middleware(['auth'])->group(function () {
    Route::get('/notaries/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}/pdf', [BookingController::class, 'exportPdf'])->name('bookings.exportPdf');
});

// Rrugët për admin (me middleware admin nëse ekziston)


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/notaries', [AdminController::class, 'listNotaries'])->name('notaries.index');
    Route::get('/notaries/create', [AdminController::class, 'createNotary'])->name('notaries.create');
    Route::post('/notaries', [AdminController::class, 'storeNotary'])->name('notaries.store');
    Route::get('/notaries/{id}/edit', [AdminController::class, 'editNotary'])->name('notaries.edit');
    Route::put('/notaries/{id}', [AdminController::class, 'updateNotary'])->name('notaries.update');
    Route::delete('/notaries/{id}', [AdminController::class, 'destroyNotary'])->name('notaries.destroy');
});

Route::middleware(['auth', 'notary'])->group(function () {
    Route::get('/notary/dashboard', [NotaryController::class, 'dashboard'])->name('notary.dashboard');
      Route::get('/notary/slots/create', [NotarySlotController::class, 'create'])->name('notary.slots.create');
    Route::post('/notary/slots', [NotarySlotController::class, 'store'])->name('notary.slots.store');
    Route::get('/notary/bookings/{id}/pdf', [NotaryBookingController::class, 'downloadPdf'])->name('notary.booking.pdf');
});

