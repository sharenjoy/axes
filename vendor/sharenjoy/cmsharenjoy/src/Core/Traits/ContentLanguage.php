<?php

namespace Sharenjoy\Cmsharenjoy\Core\Traits;

use Sharenjoy\Cmsharenjoy\Core\Scopes\ContentLanguageScope;

trait ContentLanguage {

    /**
     * Boot the global scope trait for a model.
     *
     * @return void
     */
    public static function bootContentLanguage()
    {
        static::addGlobalScope(new ContentLanguageScope);
    }

}