<?php

namespace App\Providers;

use App\Models\Feature;
use App\Models\License;
use App\Models\Plan;
use App\Models\Product;
use App\Observers\FeatureObserver;
use App\Observers\LicenseObserver;
use App\Observers\PlanObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Product::observe(ProductObserver::class);
        Feature::observe(FeatureObserver::class);
        Plan::observe(PlanObserver::class);
        License::observe(LicenseObserver::class);
    }
}
