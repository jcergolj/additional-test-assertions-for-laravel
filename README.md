# Additional Test Assertions For Laravel

For now there is only one assertion. I am considering adding assertions from my other packages:
- [jcergolj/laravel-form-request-assertions ](https://github.com/jcergolj/laravel-form-request-assertions)
- [jcergolj/laravel-view-test-assertions](https://github.com/jcergolj/laravel-view-test-assertions)

## Installation
Required PHP >=8.0

```bash
composer require --dev jcergolj/additional-test-assertions-for-laravel
```

## Assertions

### assertMiddlewareIsApplied
```
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
```
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
