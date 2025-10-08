<?php

namespace Kayintveen\LaravelPayNL\Facades;

use Illuminate\Support\Facades\Facade;

class PayNL extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'paynl';
    }
}
