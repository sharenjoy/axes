<?php

namespace App\Modules\Post;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class PostValidator extends AbstractLaravelValidator
{
    public $unique = ['title'];

    public $rules = [
        'title'     => 'required|unique:posts,title',
        'type'       => 'required',
        'tag'       => 'required',
        'content'   => 'required',
        'published_at' => 'required',
    ];

}