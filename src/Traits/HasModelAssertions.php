<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel\Traits;

use function PHPUnit\Framework\assertTrue;

trait HasModelAssertions
{
    /**
     * @param  string  $modelName the fully qualified model class name
     * @param  string  $event one of the eloquent events e.g. created, updated, deleted...
     * @return void
     */
    public function assertHasObserver($modelName, $event)
    {
        if (is_string($modelName)) {
            $model = app($modelName);
        } else {
            $model = $modelName;
        }

        $model = app($modelName);
        assertTrue($model->getEventDispatcher()->hasListeners("eloquent.{$event}: ".$modelName));
    }

    /**
     * @param  string  $modelName the fully qualified model class name
     * @param  string  $scopeName the fully qualified scope class name
     * @return void
     */
    public function assertModelHasGlobalScope($modelName, $scopeClass)
    {
        if (is_string($modelName)) {
            $model = app($modelName);
        } else {
            $model = $modelName;
        }

        assertTrue($model->hasGlobalScope($scopeClass));
    }
}
