<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Usage
    |--------------------------------------------------------------------------
    |
    | // default
    | protected $listConfig = [
    |    'title'        => ['name'=>'merit_title',         'align'=>'',       'width'=>''],
    |    'sn'           => ['name'=>'merit_sn',            'align'=>'',       'width'=>''],
    |    'price'        => ['name'=>'merit_price',         'align'=>'right',  'width'=>'200'],
    |    'head'         => ['name'=>'merit_head',          'align'=>'center', 'width'=>'80',  'type'=>'head'],
    |    'table_number' => ['name'=>'merit_table_number',  'align'=>'right',  'width'=>'80',  'relactions' => 'users.name'],
    |    'type_visible' => ['name'=>'merit_type_visible',  'align'=>'center', 'width'=>'120', 'lists' => 'merit.typevisible'],
    |    'img'          => ['name'=>'image',               'align'=>'center', 'width'=>'180', 'imageWidth' => '160'],
    |    'updated_at'   => ['name'=>'updated',             'align'=>'center', 'width'=>'180'],
    | ];
    |
    | // grid 
    | protected $listConfig = [
    |     'title'        => ['start'=>'<h3>',  'end'=>'</h3>', 'type' => 'grid'],
    |     'description'  => ['start'=>'<p>',   'end'=>'</p>',  'type' => 'grid'],
    |     'start_at'     => ['start'=>'<p><strong>起始於：</strong> ',   'end'=>'</p>',   'type' => 'grid'],
    |     'end_at'       => ['start'=>'<p><strong>結束於：</strong> ',   'end'=>'</p>',   'type' => 'grid'],
    | ];
    |
    */

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

    'grid' => [
        'pagination-div-class' => 'col-xs-7 col-sm-7 col-right',
        'pagecount-div-class' => 'col-xs-5 col-sm-5 col-left',
    ],

];
