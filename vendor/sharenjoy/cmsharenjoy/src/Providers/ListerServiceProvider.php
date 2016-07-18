<?php namespace Sharenjoy\Cmsharenjoy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Sharenjoy\Cmsharenjoy\Service\Lister\Lister;

class ListerServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->registerListerTransport();
    }

    /**
     * Register the Lister Transport instance.
     *
     * @param  array  $config
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function registerListerTransport()
    {
        $config = $this->app['config']->get('lister');

        $driver = $config['driver'];
        
        $this->app->singleton(
            'Sharenjoy\Cmsharenjoy\Service\Lister\ListerInterface',
            function() use ($driver)
            {
                switch ($driver)
                {
                    case 'default':
                        return new Lister();
                        break;
                    
                    default:
                        throw new \InvalidArgumentException();
                        break;
                }
            }
        );
    }

    public function boot()
    {
        // Adding an Aliac in app/config/app.php
        AliasLoader::getInstance()->alias('Lister', 'Sharenjoy\Cmsharenjoy\Service\Lister\Facades\Lister');
    }

    public function provides()
    {
        return array();
    }
}
