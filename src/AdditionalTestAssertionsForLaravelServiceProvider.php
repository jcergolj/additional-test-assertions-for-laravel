<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use Illuminate\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;
use Jcergolj\AdditionalTestAssertionsForLaravel\ComponentTestAssertions;
use Jcergolj\AdditionalTestAssertionsForLaravel\MiddlewareTestAssertions;

class AdditionalTestAssertionsForLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        TestResponse::mixin(new MiddlewareTestAssertions());
        TestResponse::mixin(new ComponentTestAssertions());
    }

    public function register()
    {

    }
}
