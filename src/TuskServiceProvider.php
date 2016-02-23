<?php

namespace Typesaucer\Tusk;

use Typesaucer\Tusk\Plugins;
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
            return "<?= app('Typesaucer/Tusk/Plugin')->tusk($content); ?>";
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Typesaucer/Tusk/Plugin', function()
        {
            return new Plugin;
        });
    }
}
