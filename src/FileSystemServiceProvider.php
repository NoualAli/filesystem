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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nldev');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'FileSystem');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');


        // Register the service the package provides.
        $this->app->singleton('filesystem', function ($app) {
            return new FileSystem;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['filesystem'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
    }
}
