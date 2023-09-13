<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

class AdditionalTestAssertionsForLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        TestResponse::mixin(new MiddlewareTestAssertions());
        TestResponse::mixin(new ComponentTestAssertions());
    }

    public function register()
    {
        $this->app->bind('CustomQueueFake', function ($app) {
            return new CustomQueueFake();
        });
    }
}
