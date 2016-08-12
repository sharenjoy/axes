<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Category Model
    |--------------------------------------------------------------------------
    |
    | When using the "eloquent" driver, we need to know which
    | Eloquent models should be used throughout Up.
    |
    */

    'categories' => [

        'model' => 'App\Modules\Category\Category',
    ],

    /*
    |--------------------------------------------------------------------------
    | Category Hierarchy Model
    |--------------------------------------------------------------------------
    |
    | When using the "eloquent" driver, we need to know which
    | Eloquent models should be used throughout Up.
    |
    */

    'categoryHierarchy' => [

        'model' => 'Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryHierarchy\Hierarchy',
    ],

    /*
    |--------------------------------------------------------------------------
    | Category Relate Model
    |--------------------------------------------------------------------------
    |
    | When using the "eloquent" driver, we need to know which
    | Eloquent models should be used throughout Up.
    |
    */

    'CategoryRelates' => [

        'model' => 'Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryRelates\Relate',
    ],

];
