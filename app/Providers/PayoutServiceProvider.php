<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Payout;
use App\Services\PayoutService;

class PayoutServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Payout::class, function() {

                return new PayoutService;
        });
    }

    public function provides()
    {
        return [ 
        
            Payout::class 

        ];
    }
}
