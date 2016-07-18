<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Facades;

use Illuminate\Support\Facades\Facade;

class Formaker extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Sharenjoy\Cmsharenjoy\Service\Formaker\FormakerInterface'; 
    }

}