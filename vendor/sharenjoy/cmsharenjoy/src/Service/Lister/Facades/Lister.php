<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Facades;

use Illuminate\Support\Facades\Facade;

class Lister extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Sharenjoy\Cmsharenjoy\Service\Lister\ListerInterface'; 
    }

}