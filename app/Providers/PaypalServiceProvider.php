<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Payment;
use App\Services\PaypalService;

class PaypalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Payment::class, function() {

            return new PaypalService(
                        new \PayPal\Rest\ApiContext (
                            new \PayPal\Auth\OAuthTokenCredential(
                                env('PAYPAL_CLIENT_ID'),     
                                env('PAYPAL_CLIENT_SECRET')
                            )
                        )
                    );
        });
    }
}
