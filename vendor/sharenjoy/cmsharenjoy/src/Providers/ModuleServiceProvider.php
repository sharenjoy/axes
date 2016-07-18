<?php namespace Sharenjoy\Cmsharenjoy\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Sharenjoy\Cmsharenjoy\Modules\Post\Post;
use Sharenjoy\Cmsharenjoy\Modules\Post\PostRepository;
use Sharenjoy\Cmsharenjoy\Modules\Post\PostValidator;
use Sharenjoy\Cmsharenjoy\Modules\Category\CategoryRepository;
use Sharenjoy\Cmsharenjoy\Modules\Category\CategoryValidator;
use Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\Category;
use Sharenjoy\Cmsharenjoy\Modules\Tag\Tag;
use Sharenjoy\Cmsharenjoy\Modules\Tag\TagRepository;
use Sharenjoy\Cmsharenjoy\Modules\Tag\TagValidator;
use Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\Provider as CategoryProvider;
use Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryRelates\Provider as CategoryRelateProvider;
use Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryHierarchy\Provider as CategoryHierarchyProvider;
use Sharenjoy\Cmsharenjoy\Service\Categorize\Categorize;

class ModuleServiceProvider extends ServiceProvider {

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
        // The Post Binding
        $this->app->bind('Sharenjoy\Cmsharenjoy\Modules\Post\PostInterface', function()
        {
            return new PostRepository(new Post, new PostValidator);
        });

        // The Tag Binding
        $this->app->bind('Sharenjoy\Cmsharenjoy\Modules\Tag\TagInterface', function()
        {
            return new TagRepository(new Tag, new TagValidator);
        });

        // The Category Binding
        $this->app->bind('Sharenjoy\Cmsharenjoy\Modules\Category\CategoryInterface', function()
        {
            return new CategoryRepository(new Category, new CategoryValidator);
        });

        $this->registerCategoryProvider();
        $this->registerCategoryRelateProvider();
        $this->registerCategoryHierarchyProvider();

        $this->app['categorize'] = $this->app->share(function($app)
        {
            return new Categorize(
                $app['config'],
                $app['categorize.category'],
                $app['categorize.categoryRelate'],
                $app['categorize.categoryHierarchy']
            );
        });
    }

    /**
     * Register category provider.
     *
     * @return \CategoryProvider
     */
    protected function registerCategoryProvider()
    {
        $this->app['categorize.category'] = $this->app->share(function($app)
        {
            $model = $app['config']->get('categorize.categories.model');

            return new CategoryProvider($model);
        });
    }

    /**
     * Register category hierarchy provider.
     *
     * @return \CategoryHierarchyProvider
     */
    protected function registerCategoryHierarchyProvider()
    {
        $this->app['categorize.categoryHierarchy'] = $this->app->share(function($app)
        {
            $model = $app['config']->get('categorize.categoryHierarchy.model');

            return new CategoryHierarchyProvider($model);
        });
    }

    /**
     * Register category relate provider.
     *
     * @return \CategoryHierarchyProvider
     */
    protected function registerCategoryRelateProvider()
    {
        $this->app['categorize.categoryRelate'] = $this->app->share(function($app)
        {
            $model = $app['config']->get('categorize.categoryRelates.model');

            return new CategoryRelateProvider($model);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Auto create app alias with boot method.
        AliasLoader::getInstance()->alias('Categorize', 'Sharenjoy\Cmsharenjoy\Service\Categorize\Facades\Categorize');
    }

}