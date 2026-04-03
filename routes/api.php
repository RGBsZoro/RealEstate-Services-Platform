<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusinessAccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('register/verify', [AuthController::class, 'verifyRegister']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
  Route::delete('logout', [AuthController::class, 'logout']);
  Route::post('business-accounts', [BusinessAccountController::class, 'store']);
  Route::post('business-accounts/{businessAccount}/step1', [BusinessAccountController::class, 'step1']);
  Route::post('business-accounts/{businessAccount}/step2', [BusinessAccountController::class, 'step2']);
  Route::post('business-accounts/{businessAccount}/step3', [BusinessAccountController::class, 'step3']);
  Route::post('business-accounts/{businessAccount}/step4', [BusinessAccountController::class, 'step4']);
});
