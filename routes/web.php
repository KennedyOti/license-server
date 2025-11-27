<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Portal\ApiDocsController;
use App\Http\Controllers\Portal\AuditLogController;
use App\Http\Controllers\Portal\CompanyController;
use App\Http\Controllers\Portal\FeatureController;
use App\Http\Controllers\Portal\LicenseController;
use App\Http\Controllers\Portal\PlanController;
use App\Http\Controllers\Portal\ProductController;
use App\Http\Controllers\Portal\SettingsController;
use App\Http\Controllers\Portal\UserController;
use App\Http\Controllers\Portal\WebhookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API Documentation
    Route::get('/api/docs', function () {
        return view('api.docs');
    })->name('api.docs');

    // Portal routes with role-based access
    Route::middleware('role:read-only,admin,owner')->prefix('portal')->name('portal.')->group(function () {
        // Companies
        Route::resource('companies', CompanyController::class);

        // Users
        Route::resource('users', UserController::class);

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

        // API Docs
        Route::get('api-docs', [ApiDocsController::class, 'index'])->name('api_docs.index');

        // Products
        Route::resource('products', ProductController::class);

        // Features
        Route::resource('features', FeatureController::class);

        // Plans
        Route::resource('plans', PlanController::class);
        Route::post('plans/{plan}/assign-feature', [PlanController::class, 'assignFeature'])->name('plans.assign_feature');
        Route::delete('plans/{plan}/features/{feature}', [PlanController::class, 'removeFeature'])->name('plans.remove_feature');

        // Licenses
        Route::resource('licenses', LicenseController::class);
        Route::post('licenses/{license}/revoke', [LicenseController::class, 'revoke'])->name('licenses.revoke');
        Route::post('licenses/{license}/suspend', [LicenseController::class, 'suspend'])->name('licenses.suspend');

        // Webhooks
        Route::get('webhooks', [WebhookController::class, 'index'])->name('webhooks.index');
        Route::put('webhooks', [WebhookController::class, 'update'])->name('webhooks.update');

        // Audit Logs
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
    });

    // Owner-only manage routes
    Route::middleware('role:owner')->prefix('portal')->name('portal.')->group(function () {
        Route::get('manage-features', [FeatureController::class, 'manage'])->name('features.manage');
        Route::get('manage-plans', [PlanController::class, 'manage'])->name('plans.manage');
        Route::get('manage-licenses', [LicenseController::class, 'manage'])->name('licenses.manage');
        Route::get('manage-audit-logs', [AuditLogController::class, 'manage'])->name('audit_logs.manage');
    });

    // Profile
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/{id}/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
