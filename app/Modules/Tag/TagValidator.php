<?php

namespace App\Modules\Tag;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class TagValidator extends AbstractLaravelValidator
{
    public $unique = [];
    
    public $rules  = [
        'tag' => 'required|min:1'
    ];

}