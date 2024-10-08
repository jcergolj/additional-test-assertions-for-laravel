# Additional Test Assertions For Laravel

If you like what you are seeing condider checking out those packages too:
- [jcergolj/laravel-form-request-assertions ](https://github.com/jcergolj/laravel-form-request-assertions)
- [jcergolj/laravel-view-test-assertions](https://github.com/jcergolj/laravel-view-test-assertions)

## Installation
Required PHP >=8.0

```bash
composer require --dev jcergolj/additional-test-assertions-for-laravel
```

## Assertions

### assertMiddlewareIsApplied
```php
class UsersTest extends TestCase
{
    /** @test */
    public function assert_auth_middleware_is_applied()
    {
        $response = $this->delete(route('users.index'));
        $response->assertMiddlewareIsApplied('auth');
    }
}
```

### assertViewHasComponent
```php
# users/index.blade.php
<?php
<x-layouts.app>
    <x-users-table />
</x-layouts.app>

# test
class UsersTest extends TestCase
{
    /** @test */
    public function assert_view_has_users_table_component()
    {
        $response = $this->get(route('users.index'));
        $response->assertViewHasComponent('components.users-table');
    }
}
```

### assertPushedAll
Assert that all jobs were dispatched. Inspired by `Http::assertSentInOrder()`, however here order of dispatched job is not important.
```php
# routes/web.php
<?php
    Route::get('dispatch-jobs', function () {
        FirstTestJob::dispatch('Joe');
        FirstTestJob::dispatch('Will');
        SecondTestJob::dispatch('Jane');
        SecondTestJob::dispatch('Bob');
        SecondTestJob::dispatch('Bob');
    });

# FirstTestJob.php and SecondTestJob.php are the same
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FirstTestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $name)
    {
    }

    public function handle(): void
    {
    }
}

# test
use Illuminate\Support\Facades\Queue;
use Jcergolj\AdditionalTestAssertionsForLaravel\Facades\CustomQueueFake;

class ExampleTest extends TestCase
{
    /** @test */
    function assert_all_job_has_been_dispatched()
    {
        Queue::fake();

        $this->get('dispatch-jobs');

        CustomQueueFake::assertPushedAll([
            function (FirstTestJob $job) {
                $this->assertSame('Joe', $job->name);
                return true;
            },
            function (FirstTestJob $job) {
                $this->assertSame('Will', $job->name);
                return true;
            },
            function (SecondTestJob $job) {
                $this->assertSame('Bob', $job->name);
                return true;
            },
            function (SecondTestJob $job) {
                $this->assertSame('Bob', $job->name);
                return true;
            },
            // test passes even if jane's job is referenced at the end
            function (SecondTestJob $job) {
                $this->assertSame('Jane', $job->name);
                return true;
            },
        ]);
    }
}
```

### Additional model test assertions

#### assertHasObserver
```php
<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    // add this trait
    use \Jcergolj\AdditionalTestAssertionsForLaravel\Traits\HasModelAssertions;

    /** @test */
    public function assert_user_has_saving_observer_applied()
    {
        $this->assertModelHasObserver(User::class, 'saving');

        $this->assertModelHasObserver(app(User::class), 'saving');
    }
}
```

#### assertModelHasGlobalScope
```php
<?php

namespace Tests\Unit\Models;

use App\Models\Scopes\UserCustomScope;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    // add this trait
    use \Jcergolj\AdditionalTestAssertionsForLaravel\Traits\HasModelAssertions;

    /** @test */
    public function assert_user_has_user_custom_global_scope_applied()
    {
        $this->assertModelHasGlobalScopeApplied(User::class, UserCustomScope::class);

        $this->assertModelHasGlobalScopeApplied(app(User::class), UserCustomScope::class);
    }
}
```
