<?php

namespace NLDev\FileSystem;

use Illuminate\Http\UploadedFile;
use NLDev\FileSystem\Models\FileSystemUploaderModel;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\File as SMFile;

class FileSystemUploader
{

    /**
     * Upload new resource to database and local storage
     *
     * @param UploadedFile $file
     * @param mixed $model
     * @param string $directory
     *
     * @return bool
     */
    public function upload(UploadedFile $file, $model, string $directory = 'uploads'): bool
    {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $uploadedFile = $file->move(public_path($directory), $file->hashName());
        $file = $this->store($uploadedFile, $directory, $model);

        return $uploadedFile || $file;
    }

    /**
     * Create new resource in database storage
     *
     * @param SMFile $file
     * @param string $directory
     *
     * @return FileSystemUploaderModel
     */
    private function store(SMFile $file, string $directory, $model): FileSystemUploaderModel
    {
        $name = $file->getFilename();
        $extension = $file->getExtension();
        $mimeType = mime_content_type(public_path($directory . '/' . $file->getFilename()));
        $size = $file->getSize();

        return FileSystemUploaderModel::create([
            'file_name' => $name,
            'mimetype' => $mimeType,
            'extension' => $extension,
            'size' => $size,
            'directory' => $directory,
            'callable_id' => $model->id,
            'callable_type' => get_class($model)
        ]);
    }

    /**
     * Remove file from database and storage
     *
     * @param ModelFile $file
     *
     * @return bool
     */
    public function remove(FileSystemUploaderModel $file): bool
    {
        if (File::exists($file->public_path)) {
            unlink($file->public_path);
        }
        return $file->delete();
    }

    /**
     * Confirme that facade is operational
     *
     * @return string
     */
    public function check(): string
    {
        return 'FS Facade is operational';
    }
}
