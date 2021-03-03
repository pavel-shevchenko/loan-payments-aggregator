<?php

namespace App\Providers;

use PavelShev\LoanCalculator\AnnuityCalculator;
use PavelShev\LoanCalculator\DifferentiatedCalc;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Services for mortgage facades
        $this->app->singleton('annuity', AnnuityCalculator::class);
        $this->app->singleton('differentiated', DifferentiatedCalc::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
