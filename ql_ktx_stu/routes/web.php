<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BedController;
use App\Http\Controllers\Admin\RegisterRequestController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\StudentOfficialController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Guest\RegisterController as GuestRegisterController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (HOME luôn cho truy cập)
|--------------------------------------------------------------------------
*/

// Serve avatars (fix cho Windows)
Route::get('/storage/avatars/{filename}', function ($filename) {
    $path = storage_path('app/public/avatars/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('avatar.serve');

// Home Guest (ai cũng xem được)
Route::get('/', function () {
    return view('guest.home');
})->name('guest.home');


/*
|--------------------------------------------------------------------------
| GUEST ONLY (chỉ cho người chưa đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('guest.custom')->prefix('/')->group(function () {

    // Form đăng ký lưu trú
    Route::get('register', [GuestRegisterController::class, 'create'])
        ->name('guest.register');

    // Submit đăng ký
    Route::post('register', [GuestRegisterController::class, 'store'])
        ->name('guest.register.submit');

    // Tra cứu trạng thái
    Route::get('register/status', [GuestRegisterController::class, 'statusForm'])
        ->name('guest.status');

    // Submit tra cứu trạng thái
    Route::post('register/status', [GuestRegisterController::class, 'checkStatus'])
        ->name('guest.status.check');

    // Hướng dẫn
    Route::get('guide', [GuestRegisterController::class, 'guide'])
        ->name('guest.guide');
});
// =========================
// AUTH
// =========================

// LOGIN + FORGOT + RESET (chỉ dành cho khách chưa đăng nhập)
Route::middleware('guest.custom')->group(function () {

    // login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // forgot password
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    // reset password (email link)
    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// LOGOUT (chỉ dành cho user đăng nhập)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =========================
// ADMIN ROUTES
// =========================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

     //Rooms
    Route::resource('rooms', RoomController::class);

    //Beds
    Route::resource('beds', BedController::class);

    // Register Requests
    Route::get('register-requests', 
        [RegisterRequestController::class,'index']
    )->name('register.index');

    // Students Official (Import CSV)
    Route::get('students/import', [StudentOfficialController::class, 'importForm'])->name('students.import');
    Route::post('students/import', [StudentOfficialController::class, 'import'])->name('students.store');
    Route::get('students', [StudentOfficialController::class, 'index'])->name('students.index');

    Route::get('register-requests/{id}', 
        [RegisterRequestController::class,'show']
    )->name('register.show');

    Route::post('register-requests/{id}/approve', 
        [RegisterRequestController::class,'approve']
    )->name('register.approve');

    Route::post('register-requests/{id}/reject', 
        [RegisterRequestController::class,'reject']
    )->name('register.reject');

    // DormitoryRecord
    Route::get('residents', [ResidentController::class, 'index'])->name('residents.index');
    Route::post('residents/{id}/change-room', [ResidentController::class, 'changeRoom'])->name('residents.change_room');
    Route::post('residents/{id}/extend', [ResidentController::class, 'extendStay'])->name('residents.extend');
    Route::post('residents/{id}/checkout', [ResidentController::class, 'checkout'])->name('residents.checkout');
    Route::get('residents/{user}/history', [ResidentController::class, 'history'])->name('residents.history');

    //Activitylogs
    Route::get('activity-logs', [ActivityLogController::class, 'index'])
    ->name('activity.index');

});


// =========================
// STUDENT ROUTES
// =========================
Route::middleware(['auth', 'student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    
    // Phòng - Giường
    Route::get('/room', [StudentController::class, 'roomInfo'])->name('room');
    
    // Lịch sử lưu trú
    Route::get('/history', [StudentController::class, 'history'])->name('history');
    
    // Hồ sơ cá nhân
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [StudentController::class, 'profileUpdate'])->name('profile.update');
    
    // Đổi mật khẩu
    Route::get('/password', [StudentController::class, 'passwordForm'])->name('password');
    Route::post('/password', [StudentController::class, 'passwordUpdate'])->name('password.update');
    
    // Trạng thái đăng ký
    Route::get('/registration-status', [StudentController::class, 'registrationStatus'])->name('registration.status');
});

