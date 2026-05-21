<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusinessAccountController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceReportController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\FCMController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth routes with rate limiting
Route::middleware(['guest'])->prefix('auth')->group(function () {

  // login & register routes with rate limiting
  Route::middleware('throttle:login_register')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
  });

  // OTP verification route with its own rate limiting
  Route::post('register/verify', [AuthController::class, 'verifyRegister'])->middleware('throttle:verify_otp');

  // password reset routes with appropriate rate limiting
  Route::prefix('password')->group(function () {
    Route::post('forgot', [AuthController::class, 'forgotPassword'])->middleware('throttle:forgot_password');
    Route::post('verify-otp', [AuthController::class, 'verifyForgotPasswordOtp'])->middleware('throttle:verify_otp');
    Route::post('reset', [AuthController::class, 'resetPassword'])->middleware('throttle:login_register');
  });
});

// protected routes
Route::middleware(['auth:api'])->group(function () {
  Route::delete('auth/logout', [AuthController::class, 'logout']);

  // store fcm token 
  Route::post('fcm/register-token', [FCMController::class, 'store'])
    ->defaults('guardName', 'api');

  // create business accounts
  Route::post('business-accounts/', [BusinessAccountController::class, 'store']);

  // my business accounts
  Route::prefix('my-business-accounts')->group(function () {
    Route::get('/', [BusinessAccountController::class, 'index']);
    Route::get('{businessAccount}', [BusinessAccountController::class, 'show']);
    Route::put('{businessAccount}', [BusinessAccountController::class, 'update']);
    Route::delete('{businessAccount}', [BusinessAccountController::class, 'destroy']);
    Route::delete('{businessAccount}/media/{mediaId}', [BusinessAccountController::class, 'deleteMedia']);
  });

  // show services
  Route::get('services', [ServiceController::class, 'index']);
  Route::get('services/{service}', [ServiceController::class, 'show']);

  // routes that require approved business account 
  Route::middleware(['hasApprovedBusinessAccount'])->group(function () {
    // my services
    Route::prefix('my-services')->group(function () {
      Route::get('/', [ServiceController::class, 'getMyServices']);
      Route::get('/{service}', [ServiceController::class, 'showMyService']);
      Route::put('{service}', [ServiceController::class, 'update']);
      Route::delete('{service}', [ServiceController::class, 'destroy']);
      Route::delete('{service}/media/{mediaId}', [ServiceController::class, 'deleteMedia']);
    });

    Route::prefix('services/')->group(function () {
      // create service
      Route::post('', [ServiceController::class, 'store']);

      // service requests
      Route::prefix('requests/')->group(function () {
        Route::get('wallet', [ServiceRequestController::class, 'index']);
        Route::get('calendar', [ServiceRequestController::class, 'getMyCalendarEvents']);
        Route::post('', [ServiceRequestController::class, 'store']);
        Route::get('{service}/booked-time-slots', [ServiceRequestController::class, 'getBookedTimeSlots']);
        Route::put('{serviceRequest}', [ServiceRequestController::class, 'update']);
        Route::put('{serviceRequest}/approve', [ServiceRequestController::class, 'approve']);
        Route::put('{serviceRequest}/reject', [ServiceRequestController::class, 'reject']);
        Route::post('{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel']);

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
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/{notification}', [NotificationController::class, 'destroy']);
  });

  // report service
  Route::post('services/{service}/report', [ServiceReportController::class, 'store']);

  // sliders
  Route::get('sliders', [SliderController::class, 'index']);

  // chats
  Route::prefix('chats')->group(function () {
    Route::get('/', [ChatController::class, 'index']);
    Route::get('/{conversation}', [ChatController::class, 'show'])->middleware('can:view,conversation');
    Route::post('/', [ChatController::class, 'store']);
  });

  // favorites
  Route::prefix('favorites')->group(function () {
    Route::get('/', [FavoriteController::class, 'index']);
    Route::post('/', [FavoriteController::class, 'store']);
    Route::delete('/{service}', [FavoriteController::class, 'destroy']);
  });

  // profile
  Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show']);
    Route::post('/update', [ProfileController::class, 'updateProfile'])->middleware('throttle:profile_update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->middleware('throttle:password_update');
    Route::post('/phone/request', [ProfileController::class, 'requestPhoneUpdate']);
    Route::post('/phone/verify', [ProfileController::class, 'verifyPhoneUpdate'])->middleware('throttle:verify_otp');
  });

  // categories & dynamic fields
  Route::prefix('categories')->group(function () {
    Route::get('/main', [CategoryController::class, 'mainCategories']);
    Route::get('/{category}/sub', [CategoryController::class, 'subCategories']);
    Route::get('/{category}/dynamic-fields', [CategoryController::class, 'getDynamicFildes']);
  });

  // cities
  Route::get('cities', [BusinessAccountController::class, 'getAllCities']);
});
