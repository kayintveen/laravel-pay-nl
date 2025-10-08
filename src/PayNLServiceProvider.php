<?php

namespace Kayintveen\LaravelPayNL;

use Illuminate\Support\ServiceProvider;

class PayNLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/paynl.php',
            'paynl'
        );

        $this->app->singleton('paynl', function ($app) {
            $config = $app['config']['paynl'];

            return new PayNLClient(
                tokenCode: $config['token_code'] ?? '',
                apiToken: $config['api_token'] ?? '',
                serviceId: $config['service_id'] ?? '',
                testMode: $config['test_mode'] ?? false
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/paynl.php' => config_path('paynl.php'),
            ], 'paynl-config');
        }
    }
}
