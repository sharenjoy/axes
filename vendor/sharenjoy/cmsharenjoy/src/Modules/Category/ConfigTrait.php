<?php namespace Sharenjoy\Cmsharenjoy\Modules\Category;

trait ConfigTrait {

    protected $eventItem = [
        'creating'    => ['user_id'],
        'updating'    => ['user_id'],
    ];

    public $filterFormConfig = [];

    public $formConfig = [
        'title'              => ['order' => '20'],
        'slug'               => ['order' => '30'],
        'description'        => ['order' => '40']
    ];

}
