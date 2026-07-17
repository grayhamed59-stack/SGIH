<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\HospitalSetting;

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
        Schema::defaultStringLength(191);

        // Partager les paramètres de l'hôpital à toutes les vues (V1 SaaS)
        if (!app()->runningInConsole() && Schema::hasTable('hospital_settings')) {
            View::share('globalHospital', HospitalSetting::current());
        }
    }
}
