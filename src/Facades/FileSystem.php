<?php

namespace NLDev\FileSystem\Facades;

use Illuminate\Support\Facades\Facade;

class FileSystem extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'filesystem';
    }
}
