<?php namespace Sharenjoy\Cmsharenjoy\Setting\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Sharenjoy\Cmsharenjoy\Setting\SettingInterface'; 
    }

}