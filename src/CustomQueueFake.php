<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Traits\ReflectsClosures;
use PHPUnit\Framework\AssertionFailedError;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;

class CustomQueueFake
{
    use ReflectsClosures;

    public function assertPushedAll($callbacks = null)
    {
        $jobs = collect(Queue::connection()->pushedJobs())->flatten(1);

        assertCount(count($callbacks), $jobs, 'Number of job pushed do not match the number of callables.');

        $jobs->each(function ($job) use ($callbacks) {
            $pass = collect($callbacks)->filter(function ($callback) use ($job) {
                $class = $this->firstClosureParameterType($callback);

                return $class === get_class($job['job']);
            })->filter(function ($callback) use ($job) {
                try {
                    return $callback($job['job'], $job['queue'], $job['data']) === true;
                } catch (AssertionFailedError $e) {
                }
            });

            assertTrue($pass->count() > 0, 'Not all jobs were dispatched.');
        });
    }
}
