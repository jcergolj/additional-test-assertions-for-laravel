<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class CustomQueueFake extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CustomQueueFake';
    }
}
