<?php

namespace NLDev\FileSystem;

use Illuminate\Support\ServiceProvider;

class FileSystemServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'../migrations' => database_path('migrations'),
            __DIR__.'/Traits' => app_path('Traits'),
            __DIR__.'/Models' => app_path('Models'),
        ], 'nldev/FS');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'FileSystemUploader');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');


        // Register the service the package provides.
        $this->app->singleton('filesystem', function ($app) {
            return new FileSystemUploader;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['filesystemuploader'];
    }
}
