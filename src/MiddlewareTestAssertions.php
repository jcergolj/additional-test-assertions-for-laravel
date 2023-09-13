<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\assertContains;

class MiddlewareTestAssertions
{
    public function assertMiddlewareIsApplied()
    {
        return function ($middleware) {
            assertContains(
                $middleware,
                Route::getRoutes()->getByName(Route::currentRouteName())->gatherMiddleware(),
                Route::currentRouteName()." route doesn't contains one or more middleware",
            );

            return $this;
        };
    }
}
