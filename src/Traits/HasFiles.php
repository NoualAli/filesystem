<?php

namespace NLDev\FileUploader\Traits;

trait HasFiles{

    public function files(){
        return $this->morphMany(\NLDev\FileSystem\Models\FileUploaderModel::class, 'callable');
    }

    public function file()
    {
        return $this->morphOne(\NLDev\FileSystem\Models\FileUploaderModel::class, 'callable');
    }
}
