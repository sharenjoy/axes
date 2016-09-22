<?php

namespace App\Modules\Product;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class ProductValidator extends AbstractLaravelValidator
{
    public $unique = [];

    public $rules = [
        'title'         => 'required',
        'category_id'   => 'required|not_in:0',
        'img'           => 'required',
        'content'       => 'required',
        // 'specification' => 'required',
    ];

}