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
                Route::getCurrentRoute()->gatherMiddleware(),
                "{Route::getCurrentRoute()->action['uses']} route doesn't contains one or more middleware",
            );

            return $this;
        };
    }
}
