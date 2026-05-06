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


Route::post('register', [AuthController::class, 'register']);
Route::post('register/verify', [AuthController::class, 'verifyRegister']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
  Route::delete('logout', [AuthController::class, 'logout']);

  // store fcm token 
  Route::post('fcm/register-token', [FCMController::class, 'store'])
    ->defaults('guardName', 'api');

  // create business accounts
  Route::prefix('business-accounts/')->group(function () {
    Route::post('step1', [BusinessAccountController::class, 'step1']);
    Route::post('{businessAccount}/step2', [BusinessAccountController::class, 'step2']);
    Route::post('{businessAccount}/step3', [BusinessAccountController::class, 'step3']);
    Route::post('{businessAccount}/step4', [BusinessAccountController::class, 'step4']);
  });

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

    // create service
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
    Route::post('/update', [ProfileController::class, 'updateProfile']);
    Route::put('/password', [ProfileController::class, 'updatePassword']);
    Route::post('/phone/request', [ProfileController::class, 'requestPhoneUpdate']);
    Route::post('/phone/verify', [ProfileController::class, 'verifyPhoneUpdate']);
  });

  // categories 
  Route::prefix('categories')->group(function () {
    Route::get('/main', [CategoryController::class, 'mainCategories']);
    Route::get('/{category}/sub', [CategoryController::class, 'subCategories']);
  });
});
