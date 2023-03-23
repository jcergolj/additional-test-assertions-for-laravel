<?php

namespace Jcergolj\AdditionalTestAssertionsForLaravel;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\fail;

class ComponentTestAssertions
{
    public function assertViewHasComponent()
    {
        return function ($componentName) {
            if ($this->exceptions->first() !== null) {
                fail($this->exceptions->first()->getMessage()." in component {$componentName}");
            }

            assertArrayHasKey($componentName, $this->original->getFactory()->getFinder()->getViews(), "View is missing {$componentName} component.");

            return $this;
        };
    }
}
