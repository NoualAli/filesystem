<?php

namespace NLDev\FileUploader\Facades;

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
