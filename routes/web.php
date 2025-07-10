<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotaryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotarySlotController;
use App\Http\Controllers\NotaryBookingController;
use Illuminate\Support\Facades\Password;


/*
|--------------------------------------------------------------------------
| Rrugët Publike
|--------------------------------------------------------------------------
*/
Route::get('/', [NotaryController::class, 'index'])->name('home');
Route::get('/notaries', [NotaryController::class, 'index'])->name('notaries.index');
Route::get('/notaries/{id}', [NotaryController::class, 'show'])->name('notaries.show');
Route::get('/bookings/success', [BookingController::class, 'success'])->name('bookings.success');

/*
|--------------------------------------------------------------------------
| Autentikimi
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Verifikimi i Email-it
|--------------------------------------------------------------------------
*/

// Faqja ku përdoruesi sheh mesazhin për verifikimin, duhet të jetë me auth middleware
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Ruta e verifikimit ku hiqet auth middleware që përdoruesi të mund të verifikojë edhe pa qenë kyçur
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/login?verified=1');
    }

    $user->markEmailAsVerified();

    event(new \Illuminate\Auth\Events\Verified($user));

    return redirect('/login?verified=1')->with('success', 'Emaili juaj u verifikua me sukses! Ju lutem identifikohuni.');
})->middleware('signed')->name('verification.verify');

// Dërgimi i emailit të verifikimit përsëri (kërkon që përdoruesi të jetë kyçur)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Linku i verifikimit u dërgua!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



// Shfaq forma për të kërkuar resetim të fjalëkalimit
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Dërgo linkun për reset në email
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Forma për vendosje të fjalëkalimit të ri (pasi klikohet linku nga emaili)
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Ruajtja e fjalëkalimit të ri
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => \Hash::make($password),
            ])->save();

            event(new \Illuminate\Auth\Events\PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
/*
|--------------------------------------------------------------------------
| Rrugët për përdorues të kyçur dhe të verifikuar
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notaries/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}/pdf', [BookingController::class, 'exportPdf'])->name('bookings.exportPdf');
});

/*
|--------------------------------------------------------------------------
| Rrugët për Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Menaxhimi i përdoruesve
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users.index');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Menaxhimi i noterëve
    Route::get('/notaries', [AdminController::class, 'listNotaries'])->name('notaries.index');
    Route::get('/notaries/create', [AdminController::class, 'createNotary'])->name('notaries.create');
    Route::post('/notaries', [AdminController::class, 'storeNotary'])->name('notaries.store');
    Route::get('/notaries/{id}/edit', [AdminController::class, 'editNotary'])->name('notaries.edit');
    Route::put('/notaries/{id}', [AdminController::class, 'updateNotary'])->name('notaries.update');
    Route::delete('/notaries/{id}', [AdminController::class, 'destroyNotary'])->name('notaries.destroy');

    // Raportet mujore
    Route::get('/bookings/monthly', [AdminController::class, 'monthlyBookingsSummary'])->name('bookings.monthly');
    Route::get('/bookings/by-month', [AdminController::class, 'bookingsByMonth'])->name('bookings.byMonth');
});

/*
|--------------------------------------------------------------------------
| Rrugët për Noterët
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'notary'])->prefix('notary')->name('notary.')->group(function () {
    Route::get('/dashboard', [NotaryController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{id}/documents/download', [NotaryBookingController::class, 'downloadDocuments'])->name('booking.downloadDocuments');

    Route::prefix('slots')->name('slots.')->group(function () {
        Route::get('/create', [NotarySlotController::class, 'create'])->name('create');
        Route::post('/', [NotarySlotController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [NotarySlotController::class, 'edit'])->name('edit');
        Route::put('/{id}', [NotarySlotController::class, 'update'])->name('update');
        Route::delete('/{id}', [NotarySlotController::class, 'destroy'])->name('destroy');
        

    });

  Route::prefix('bookings')->name('booking.')->group(function () {
    Route::get('/monthly/{month?}', [NotaryBookingController::class, 'monthly'])->name('monthly');
    Route::get('/{id}/pdf', [NotaryBookingController::class, 'downloadPdf'])->name('pdf');
    Route::get('/{id}/documents/download', [NotaryBookingController::class, 'downloadDocuments'])->name('documents');
    Route::post('/{id}/upload-translation', [NotaryBookingController::class, 'uploadTranslation'])->name('uploadTranslation');
    Route::post('/{id}/upload-signature', [NotaryBookingController::class, 'uploadSignature'])->name('uploadSignature');
    Route::post('/{id}/seal', [NotaryBookingController::class, 'sealDocument'])->name('seal');
    Route::get('/{id}/sign', [NotaryBookingController::class, 'showSignatureForm'])->name('sign');
    Route::post('/{id}/sign', [NotaryBookingController::class, 'storeSignatureImage'])->name('storeSignatureImage');
    
    // ✅ Kjo është vetëm njëherë dhe është e mjaftueshme:
    Route::post('/{booking}/send-email', [NotaryBookingController::class, 'sendEmail'])->name('sendEmail');
});
});
