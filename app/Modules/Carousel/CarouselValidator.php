<?php

namespace App\Modules\Carousel;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class CarouselValidator extends AbstractLaravelValidator
{
    public $unique = [];

    public $rules = [
        'title'    => 'required',
        'type'     => 'required',
        'content'  => 'required',
        // 'link'        => 'required',
    ];

}