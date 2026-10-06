<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\News;
use App\Models\Tariff;
use App\Observers\NewsObserver;
use App\Observers\TariffObserver;

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
        // ✅ Daftarkan Observer
        News::observe(NewsObserver::class);
        Tariff::observe(TariffObserver::class);
    }
}