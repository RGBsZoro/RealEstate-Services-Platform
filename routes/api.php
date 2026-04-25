<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusinessAccountController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceReportController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\FCMController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('register/verify', [AuthController::class, 'verifyRegister']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
  Route::delete('logout', [AuthController::class, 'logout']);

  // store fcm token 
  Route::post('fcm/register-token', [FCMController::class, 'store'])
    ->defaults('guardName', 'api');

  // business accounts
  Route::prefix('business-accounts/')->group(function () {
    Route::post('', [BusinessAccountController::class, 'store']);
    Route::post('{businessAccount}/step1', [BusinessAccountController::class, 'step1']);
    Route::post('{businessAccount}/step2', [BusinessAccountController::class, 'step2']);
    Route::post('{businessAccount}/step3', [BusinessAccountController::class, 'step3']);
    Route::post('{businessAccount}/step4', [BusinessAccountController::class, 'step4']);
  });

  Route::middleware(['hasApprovedBusinessAccount'])->group(function () {
    // service
    Route::prefix('services/')->group(function () {
      Route::post('step1', [ServiceController::class, 'initialize']);
      Route::post('{service}/step2', [ServiceController::class, 'updateDetails']);
      Route::post('{service}/step3', [ServiceController::class, 'updateMedia']);
      Route::post('{service}/step4', [ServiceController::class, 'syncDynamicFields']);
      Route::post('{service}/step5', [ServiceController::class, 'submitService']);
      // service requests
      Route::prefix('requests/')->group(function () {
        Route::post('', [ServiceRequestController::class, 'store']);
        Route::put('{serviceRequest}/approve', [ServiceRequestController::class, 'approve']);
        Route::put('{serviceRequest}/reject', [ServiceRequestController::class, 'reject']);
        Route::get('sent', [ServiceRequestController::class, 'sentRequest']);
        Route::get('received', [ServiceRequestController::class, 'recivedRequest']);
        Route::delete('{serviceRequest}', [ServiceRequestController::class, 'destroy']);
        // reviews
        Route::prefix('{service}/reviews/')->group(function () {
          Route::post('', [ReviewController::class, 'store']);
          Route::get('', [ReviewController::class, 'allReviewsOnService']);
        });
      });
    });
  });

  // notifications 
  Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index']);
    Route::get('/unread', [NotificationController::class, 'getUnreadNotifications']);
    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/{notification}', [NotificationController::class, 'destroy']);
  });

  // report service
  Route::post('services/{service}/report', [ServiceReportController::class, 'store']);
});
