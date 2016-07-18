<?php namespace Sharenjoy\Cmsharenjoy\Setting;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;

class Setting extends EloquentBaseModel {

    /**
     * The table to get the data from
     * @var string
     */
    protected $table    = 'settings';

    /**
     * These are the mass-assignable keys
     * @var array
     */
    protected $fillable = [
        'id', 
        'value'
    ];

}
