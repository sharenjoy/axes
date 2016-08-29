<?php namespace App\Modules\Product;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class ProductValidator extends AbstractLaravelValidator {

    public $unique = [];

    public $rules = [
        'title'       => 'required',
        'category_id' => 'required|not_in:0',
        'img'         => 'required',
        'summary'     => 'required',
        'content_one_title' => 'required',
        'content_one'       => 'required',
        // 'content_two_title' => 'required',
        // 'content_two'       => 'required',
        // 'tag' => 'required',
    ];

}