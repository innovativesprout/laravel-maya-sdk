<?php

namespace Iss\LaravelMayaSdk\Facades;

use Illuminate\Support\Facades\Facade;

class Maya extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'maya';
    }
}
