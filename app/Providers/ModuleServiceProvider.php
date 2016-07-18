<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // The News Binding
        // $this->app->bind('App\Modules\News\NewsInterface', function()
        // {
        //     return new \App\Modules\News\NewsRepository(new \App\Modules\News\News, new \App\Modules\News\NewsValidator);
        // });

    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Auto create app alias with boot method.
        // AliasLoader::getInstance()->alias('Categorize', 'App\Service\Categorize\Facades\Categorize');
    }

}