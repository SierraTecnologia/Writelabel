<?php

namespace WriteLabel\Facades;

use Illuminate\Support\Facades\Facade;

class WriteLabel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'writelabel';
    }
}
