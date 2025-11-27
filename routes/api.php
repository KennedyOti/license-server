<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\FeatureController;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ValidationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api.key', 'throttle:60,1'])->group(function () {
    // Company
    Route::get('/companies/me', [CompanyController::class, 'me']);
    Route::put('/companies/me', [CompanyController::class, 'updateMe']);

    // Products
    Route::apiResource('products', ProductController::class);

    // Features under products
    Route::apiResource('products.features', FeatureController::class)->shallow();

    // Plans under products
    Route::apiResource('products.plans', PlanController::class)->shallow();

    // Licenses
    Route::apiResource('licenses', LicenseController::class);
    Route::post('licenses/{id}/revoke', [LicenseController::class, 'revoke']);
    Route::post('licenses/{id}/suspend', [LicenseController::class, 'suspend']);

    // Validation
    Route::post('/validate', [ValidationController::class, 'validate']);
    Route::get('/public-key', [ValidationController::class, 'publicKey']);
});