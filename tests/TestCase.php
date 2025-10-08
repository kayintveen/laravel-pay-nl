<?php

namespace Kayintveen\LaravelPayNL\Tests;

use Kayintveen\LaravelPayNL\PayNLServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PayNLServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('paynl.token_code', 'test-token-code');
        $app['config']->set('paynl.api_token', 'test-api-token');
        $app['config']->set('paynl.service_id', 'SL-1234-5678');
        $app['config']->set('paynl.test_mode', true);
    }
}
