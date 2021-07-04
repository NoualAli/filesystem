<?php

namespace NLDev\FileSystem\Traits;

trait HasFiles{

    public function files(){
        return $this->morphMany(\NLDev\FileSystem\Models\File::class, 'callable');
    }

    public function file()
    {
        return $this->morphOne(\NLDev\FileSystem\Models\File::class, 'callable');
    }
}
