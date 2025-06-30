<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonalCabinController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ForexController;
use App\Http\Controllers\IBController;
use App\Http\Controllers\BonityController;
use App\Http\Controllers\KycDocumentController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\TradingAccountController;

/*
|--------------------------------------------------------------------------
| Public (no auth)
|--------------------------------------------------------------------------
*/
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login',    [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Admin‑only (must be authenticated + have role “admin”)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api','admin'])
     ->prefix('admin')
     ->group(function () {
    // GET  /api/admin/users
    Route::get('users',      [AdminController::class, 'index']);
    // GET  /api/admin/users/{id}
    Route::get('users/{id}', [AdminController::class, 'show']);

    // additional admin dashboards
    Route::get('transactions', [AdminController::class, 'transactionsByPeriod']);
    Route::get('ib',           [AdminController::class, 'ibByPeriod']);
    Route::get('bonity',       [AdminController::class, 'bonityByPeriod']);
});

/*
|--------------------------------------------------------------------------
| Authenticated users (any logged‑in user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::post('auth/logout',  [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);

    // Your own profile
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);

    // Personal cabin
    Route::get('cabin/dashboard', [PersonalCabinController::class, 'dashboard']);
    Route::put('cabin',           [PersonalCabinController::class, 'update']);

    // Wallets & Transactions
    Route::apiResource('wallets',      WalletController::class)
         ->except(['create','edit']);
    Route::apiResource('transactions', TransactionController::class)
         ->only(['index','show','store']);

    // Trades
    Route::apiResource('trades', TradeController::class)
         ->except(['create','edit']);

    // Forex
    Route::get('forex/pairs',          [ForexController::class, 'pairs']);
    Route::get('forex/quote/{symbol}', [ForexController::class, 'quote']);

    // IB & Bonity
    Route::get('ib/{userId}',     [IBController::class, 'show']);
    Route::put('ib/{userId}',     [IBController::class, 'update']);
    Route::get('bonity/{userId}', [BonityController::class, 'calculate']);

    // KYC, Bank & Trading Accounts
    Route::apiResource('kyc-documents',      KycDocumentController::class)
         ->except(['create','edit']);
    Route::apiResource('bank-accounts',      BankAccountController::class)
         ->except(['create','edit']);
    Route::apiResource('trading-accounts',   TradingAccountController::class)
         ->except(['create','edit']);
});

/*
|--------------------------------------------------------------------------
| Fallback for anything else
|--------------------------------------------------------------------------
*/
Route::fallback(function(){
    return response()->json(['message' => 'Not Found'], 404);
});
