<?php

namespace NLDev\FileSystem\Facades;

use Illuminate\Support\Facades\Facade;

class FileUploader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'fileuploader';
    }
}