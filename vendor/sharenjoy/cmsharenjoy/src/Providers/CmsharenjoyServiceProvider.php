<?php namespace Sharenjoy\Cmsharenjoy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Sharenjoy\Cmsharenjoy\User\User;
use Sharenjoy\Cmsharenjoy\User\UserRepository;
use Sharenjoy\Cmsharenjoy\User\UserValidator;
use Sharenjoy\Cmsharenjoy\Setting\Setting;
use Sharenjoy\Cmsharenjoy\Setting\SettingRepository;
use Sharenjoy\Cmsharenjoy\Setting\SettingValidator;
use Sharenjoy\Cmsharenjoy\Utilities\Parser;
use Sharenjoy\Cmsharenjoy\Filer\FilerRepository;
use Sharenjoy\Cmsharenjoy\Service\Message\FlashMessageBag;
use Session, Request, Log;

class CmsharenjoyServiceProvider extends ServiceProvider {

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
        $config = [
            'assets',
            'categorize',
            'cmsharenjoy',
            'filer',
            'formaker',
            'lister',
            'module',
            'notification',
            'options',
        ];

        foreach ($config as $cfg)
        {
            // Merge config to allow user overwrite.
            $this->mergeConfigFrom(__DIR__.'/../../config/'.$cfg.'.php', $cfg);
        }

        $accessUrl = $this->app['config']->get('cmsharenjoy.access_url');
        
        // To define which end it is now
        $whichEnd = Request::segment(1) == $accessUrl ? 'backEnd' : 'frontEnd';
        
        Session::put('sharenjoy.whichEnd', $whichEnd);

        // Binding a bunch of repository
        $this->bindRepository();
    }

	protected function bindRepository()
	{
		// The Users Binding
		$this->app->bind('Sharenjoy\Cmsharenjoy\User\UserInterface', function()
		{
		    return new UserRepository(new User, new UserValidator);
		});

		// The Setting Bindings
		$this->app->bind('Sharenjoy\Cmsharenjoy\Setting\SettingInterface', function()
		{
		    return new SettingRepository(new Setting, new SettingValidator);
		});

        // The parser binding
        $this->app->bind('Sharenjoy\Cmsharenjoy\Utilities\Parser', function()
        {
            return new Parser;
        });

        // The Filer binding
        $driver = $this->app['config']->get('filer.driver');
        
        $this->app->bind('Sharenjoy\Cmsharenjoy\Filer\FilerInterface', function() use ($driver)
        {
            switch ($driver)
            {
                case 'file':
                    return new FilerRepository;                  
                
                default:
                    throw new \InvalidArgumentException('Invalid file driver.');
            }
        });

        $this->app->bind(
            'Illuminate\Support\Contracts\MessageProviderInterface',
            function()
            {
                return new FlashMessageBag(
                    $this->app->make('session.store')
                );
            }
        );
	}

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config' => config_path(),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../migrations' => base_path('/database/migrations')
        ], 'migration');

        // Setting the locale langage
        if (Session::has('sharenjoy.backEndLanguage'))
        {
            $this->app->setLocale(Session::get('sharenjoy.backEndLanguage'));
        }

        // backend prefix
        $accessUrl = $this->app['config']->get('cmsharenjoy.access_url');

        // Make some alias
        $this->makeAlias();

        // Loading some of files
        $this->loadIncludes($accessUrl);
        
        // Set service
        // $this->setServices();
    }

    /**
     * There are some useful alias
     * @return void
     */
    protected function makeAlias()
    {
        // For setting
        AliasLoader::getInstance()->alias('Setting', 'Sharenjoy\Cmsharenjoy\Setting\Facades\Setting');

        // For filer
        AliasLoader::getInstance()->alias('Filer', 'Sharenjoy\Cmsharenjoy\Filer\Facades\Filer');

        // For message
        AliasLoader::getInstance()->alias('Message', 'Sharenjoy\Cmsharenjoy\Service\Message\Facades\Message');
    }

	/**
     * Include some specific files from the src-root.
     * @return void
     */
    protected function loadIncludes($accessUrl)
    {
        // Add file names without the `php` extension to this list as needed.
        $filesToLoad = [
            'routes',
            'helpers'
        ];

        // Run through $filesToLoad array.
        foreach ($filesToLoad as $file)
        {
            // Add needed database structure and file extension.
            $file = __DIR__ . '/../' . $file . '.php';
            // If file exists, include.
            if (is_file($file)) include $file;
        }
    }

    protected function setServices()
    {
        // For papertrail
        if ($this->app->environment() == 'production')
        {
            $siteName  = str_replace(['http://', 'https://'], '', $this->app['config']->get('app.url'));
            $monolog   = Log::getMonolog();
            $syslog    = new \Monolog\Handler\SyslogHandler($siteName);
            $formatter = new \Monolog\Formatter\LineFormatter('%channel%.%level_name%: %message% %extra%');
            
            $syslog->setFormatter($formatter);
            $monolog->pushHandler($syslog);
        }
    }

    /**
	 * Get the services provided by the provider.
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}