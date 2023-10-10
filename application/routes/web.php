<?php

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
Route::get('find', [\App\Http\Controllers\GlobalController::class, 'findTranslations']);

require_once(base_path('routes/clients.php'));



/*Route::get('password/success', [App\Http\Controllers\Auth\ResetPasswordController::class, 'success']);
Route::get('/maintenance', [App\Http\Controllers\HomeController::class, 'maintenance'])->name('maintenance');

// Twofactor Auth
Route::get('verify', [App\Http\Controllers\TwoFactorController::class, 'show'])->name('2fa.show');
Route::post('verify', [App\Http\Controllers\TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::get('verify/resend', [App\Http\Controllers\TwoFactorController::class, 'resend'])->name('2fa.resend');

Route::group(['middleware' => 'auth'], function() {

});*/
Route::get('/ok', function () {
    return 'Hello World';
});
