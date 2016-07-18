<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | This is the lister driver for cmsharenjoy backend.
    |
    */

    'driver' => 'default',

    /*
    |--------------------------------------------------------------------------
    | The templates
    |--------------------------------------------------------------------------
    |
    | This is where the templates be loaded.
    |
    */
   
    'loadListsNamespace' => [
        'Sharenjoy\Cmsharenjoy\Service\Lister\Lists\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | The functions
    |--------------------------------------------------------------------------
    |
    | This is where the functions be loaded.
    |
    */
   
    'loadFunctionsNamespace' => [
        'Sharenjoy\Cmsharenjoy\Service\Lister\Functions\\',
    ],

    /*
    |--------------------------------------------------------------------------
    | The except function rules
    |--------------------------------------------------------------------------
    |
    | These are the exception rules.
    |
    */

    'exceptFunction' => ['list', 'create', 'order', 'handle', 'trace'],

    /*
    |--------------------------------------------------------------------------
    | Default driver
    |--------------------------------------------------------------------------
    |
    | The setting of the default driver
    |
    */

    'default' => [
        'pagination-div-class' => 'col-xs-7 col-sm-7 col-right',
        'pagecount-div-class' => 'col-xs-5 col-sm-5 col-left',
    ],

];
