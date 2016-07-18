<?php namespace Sharenjoy\Cmsharenjoy\Modules\Category;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class CategoryValidator extends AbstractLaravelValidator {

    public $unique = ['slug'];
    
    public $rules = [
        'type'  => 'required',
        'title' => 'required',
        'slug'  => 'required|unique:categories,slug',
    ];

}