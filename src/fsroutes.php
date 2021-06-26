<?php

use Illuminate\Support\Facades\Route;
use NLDev\FileSystem\FileSystemController;

Route::group(['middleware' => 'web'], function () {
    // Place all your web routes here...(Cut all `Route` which are define in `Route file`, paste here)
    Route::delete('file/{file}', [FileSystemController::class, 'destroy'])->name('files.destroy');
    Route::get('files', [FileSystemController::class, 'index'])->name('files.index');
    Route::get('files/create', [FileSystemController::class, 'create'])->name('files.create');
    Route::post('files/create', [FileSystemController::class, 'store'])->name('files.store');
});
