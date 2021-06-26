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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'FileSystem');
        $this->loadMigrationsFrom(__DIR__.'../migrations');
        $this->loadRoutesFrom(__DIR__.'/fsroutes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filesystem.php', 'filesystem');

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
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/filesystem.php' => config_path('filesystem.php'),
        ], 'filesystem.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/nldev'),
        ], 'filesystem.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/nldev'),
        ], 'filesystem.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/nldev'),
        ], 'filesystem.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
