<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\OvertimeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AnnouncementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

// Protected routes (authentication required via JwtMiddleware)
Route::middleware('auth:api')->group(function () {
    
    // Authentication
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('password', [ProfileController::class, 'changePassword']);
        Route::post('avatar', [ProfileController::class, 'uploadAvatar']);
    });

    // Attendance
    Route::prefix('attendance')->group(function () {
        Route::post('clock-in', [AttendanceController::class, 'clockIn']);
        Route::post('clock-out', [AttendanceController::class, 'clockOut']);
        Route::get('today', [AttendanceController::class, 'today']);
        Route::get('history', [AttendanceController::class, 'history']);
        Route::get('summary', [AttendanceController::class, 'summary']);
        Route::get('locations', [AttendanceController::class, 'locations']);
    });

    // Leave
    Route::prefix('leaves')->group(function () {
        Route::get('/', [LeaveController::class, 'index']);
        Route::post('/', [LeaveController::class, 'store']);
        Route::get('{id}', [LeaveController::class, 'show']);
        Route::delete('{id}', [LeaveController::class, 'destroy']);
        Route::get('types', [LeaveController::class, 'types'])->name('leaves.types');
        Route::get('balance', [LeaveController::class, 'balance'])->name('leaves.balance');
    });

    // Overtime
    Route::prefix('overtimes')->group(function () {
        Route::get('/', [OvertimeController::class, 'index']);
        Route::post('/', [OvertimeController::class, 'store']);
        Route::get('{id}', [OvertimeController::class, 'show']);
    });

    // Schedule
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('shifts', [ScheduleController::class, 'shifts']);
    });
    Route::get('holidays', [ScheduleController::class, 'holidays']);

    // Payroll
    Route::prefix('payslips')->group(function () {
        Route::get('/', [PayrollController::class, 'index']);
        Route::get('{id}', [PayrollController::class, 'show']);
        Route::get('{id}/download', [PayrollController::class, 'download']);
    });

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('{id}/read', [NotificationController::class, 'markAsRead']);
        Route::put('read-all', [NotificationController::class, 'markAllAsRead']);
    });

    // Announcements
    Route::get('announcements', [AnnouncementController::class, 'index']);
});
