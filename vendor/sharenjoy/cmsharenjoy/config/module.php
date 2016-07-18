<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Tag Module
    |--------------------------------------------------------------------------
    |
    */
   
    'tag' => [

        /*
        |
        | These are allowed model taggable
        | key: The key is relationshop method of model
        | value: This is relationship
        | sample: 'posts' => 'Sharenjoy\Cmsharenjoy\Modules\Post\Post'
        |
        */

        'taggableModel' => [],

    ],

    
    /*
    |--------------------------------------------------------------------------
    | Catrgory Module
    |--------------------------------------------------------------------------
    |
    */
   
    'category' => [

        'layer' => [
            'product' => 2
        ],
    ],

];