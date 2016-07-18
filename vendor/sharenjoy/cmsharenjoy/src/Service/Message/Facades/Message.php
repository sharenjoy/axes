<?php namespace Sharenjoy\Cmsharenjoy\Service\Message\Facades;

use Illuminate\Support\Facades\Facade;

class Message extends Facade {

    protected static function getFacadeAccessor()
    { 
        return 'Illuminate\Support\Contracts\MessageProviderInterface'; 
    }

}