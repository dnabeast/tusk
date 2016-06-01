<?php

namespace DNABeast\Tusk;

use DNABeast\Tusk\Plugins;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TuskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('tusk', function($content){
            return "<?= app('DNABeast/Tusk/Plugins')->tusk($content); ?>";
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DNABeast/Tusk/Plugins', function()
        {
            return new Plugins;
        });
    }
}
