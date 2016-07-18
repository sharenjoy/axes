<?php namespace Sharenjoy\Cmsharenjoy\Service\Notification\Facades;

use Illuminate\Support\Facades\Facade;

class Notification extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Sharenjoy\Cmsharenjoy\Service\Notification\NotificationInterface'; 
    }

}