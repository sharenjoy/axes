<?php namespace Sharenjoy\Cmsharenjoy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Sharenjoy\Cmsharenjoy\Service\Formaker\TwitterBootstrapV3;
use Request;

class FormakerServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->registerFormakerTransport();
    }

    /**
     * Register the Formaker Transport instance.
     *
     * @param  array  $config
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function registerFormakerTransport()
    {
        $accessUrl = $this->app['config']->get('cmsharenjoy.access_url');
        
        // To define which end it is now
        $end = Request::segment(1) == $accessUrl ? 'backEnd' : 'frontEnd';

        $config = $this->app['config']->get('formaker');

        if ($end == 'frontEnd')
        {
            $driver = $config['driver-front'];
        }
        elseif ($end == 'backEnd')
        {
            $driver = $config['driver-back'];
        }
        
        $this->app->singleton(
            'Sharenjoy\Cmsharenjoy\Service\Formaker\FormakerInterface',
            function() use ($driver, $end)
            {
                switch ($driver)
                {
                    case 'TwitterBootstrapV3':
                        return new TwitterBootstrapV3($end);
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
        AliasLoader::getInstance()->alias('Formaker', 'Sharenjoy\Cmsharenjoy\Service\Formaker\Facades\Formaker');
    }

    public function provides()
    {
        return array();
    }
}
