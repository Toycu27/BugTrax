<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Traits\JsonResponseTraitClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => ['required', 'exists:users', 'email'],
        'password' => ['required'],
        'device_name' => ['required'],
    ]);

    $jsonResponser = new JsonResponseTraitClass();
    $user = User::where('email', $request->email)->first();

    if (!Hash::check($request->password, $user->password)) {
        return $jsonResponser->errorResponse(
            'The provided credentials are incorrect.', 
            ['password' => 'The provided credentials are incorrect.'],
        );
    }

    return $jsonResponser->simpleResponse(true, null, 
    [
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'user' => $user,
    ]);
});

Route::delete('sanctum/token', function (Request $request) {
    $request->user()->tokens()->delete();
    Session::flush();

    $jsonResponser = new JsonResponseTraitClass();
    return $jsonResponser->simpleResponse(true);
})->middleware('auth:sanctum');
