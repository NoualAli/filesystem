<?php

namespace NLDev\FileUploader\Traits;

trait HasFiles{

    public function files(){
        return $this->morphMany(\NLDev\FileUploader\Models\FileUploaderModel::class, 'callable');
    }

    public function file()
    {
        return $this->morphOne(\NLDev\FileUploader\Models\FileUploaderModel::class, 'callable');
    }
}
