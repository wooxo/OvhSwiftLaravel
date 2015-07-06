<?php

namespace Lflaszlo\OvhSwiftLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class OvhSwiftLaravelFacade extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'OvhSwiftLaravel';
    }
}
