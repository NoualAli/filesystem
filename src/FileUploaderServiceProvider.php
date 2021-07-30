<?php

namespace NLDev\FileUploader;

use Illuminate\Support\ServiceProvider;

class FileUploaderServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../migrations' => database_path('migrations'),
        ], 'nldev/migrations');
        $this->publishes([
            __DIR__ . '/Traits' => app_path('Traits'),
        ], 'nldev/traits');
        $this->publishes([
            __DIR__ . '/Models' => app_path('Models'),
        ], 'nldev/migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'FileUploader');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');


        // Register the service the package provides.
        $this->app->singleton('fileuploader', function ($app) {
            return new FileUploader;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['fileuploader'];
    }
}
