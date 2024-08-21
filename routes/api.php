<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionSellerController;

use App\Http\Controllers\User\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Buyers api routes
Route::resource('buyers',BuyerController::class,['only' => ['index','show']]);
Route::resource('buyers.sellers',BuyerSellerController::class,['only' => ['index']]);
Route::resource('buyers.products',BuyerProductController::class,['only' => ['index']]);
Route::resource('buyers.categories',BuyerCategoryController::class,['only' => ['index']]);
Route::resource('buyers.transactions',BuyerTransactionController::class,['only' => ['index']]);

// Categories api routes
Route::resource('categories',CategoryController::class,['except' => ['create','edit']]);

// Products api routes
Route::resource('products',ProductController::class,['only' => ['index','show']]);

// Sellers api routes
Route::resource('sellers',SellerController::class,['only' => ['index','show']]);

// Transactions api routes
Route::resource('transactions',TransactionController::class,['only' => ['index','show']]);
Route::resource('transactions.categories',TransactionCategoryController::class,['only' => ['index']]);
Route::resource('transactions.sellers',TransactionSellerController::class,['only' => ['index']]);

// Users api routes
Route::resource('users',UserController::class,['except' => ['create','edit']]);

