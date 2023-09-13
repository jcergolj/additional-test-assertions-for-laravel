<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Testing\Fakes\QueueFake;
use Jcergolj\AdditionalTestAssertionsForLaravel\MyQueueManager;
use Jcergolj\AdditionalTestAssertionsForLaravel\Facades\MyQueue;
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
