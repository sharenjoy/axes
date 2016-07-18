<?php namespace Sharenjoy\Cmsharenjoy\Filer\Facades;

use Illuminate\Support\Facades\Facade;

class Filer extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Sharenjoy\Cmsharenjoy\Filer\FilerInterface'; 
    }

}