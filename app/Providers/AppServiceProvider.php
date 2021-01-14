<?php

namespace App\Providers;

use App\Category;
use App\Observers\CategoryObserver;
use App\Observers\PayoutObserver;
use App\Payout;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function () {
            Payout::observe(PayoutObserver::class);
            Category::observe(CategoryObserver::class);
        });
    }
}
