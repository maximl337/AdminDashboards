<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\FileStorage;
use App\Services\RackspaceService;
use OpenCloud\Rackspace;

class RackspaceServiceProvider extends ServiceProvider
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
        $this->app->singleton(FileStorage::class, function() {

                return new RackspaceService(
                        new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, [
                                'username' => env('RACKSPACE_USERNAME'),
                                'apiKey'   => env('RACKSPACE_KEY')
                        ])
                    );
        });
    }
}
