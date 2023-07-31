<?php

namespace Vcian\LaravelUtils\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelUtilServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $file = __DIR__.'/LaravelUtils.php';
        if (file_exists($file)) {
            require_once($file);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}