<?php

namespace App\Modules\Post;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class PostRepository extends EloquentBaseRepository implements PostInterface
{    
    public function __construct(Post $model, ValidableInterface $validator)
    {
        $this->model     = $model;
        $this->validator = $validator;
    }

    public function makeFrontendQuery($method = 'listQuery', $model = null)
    {
        $model = $model ?: $this->model;

        return $model->$method()->with(['album.files', 'tags'])->whereStatusId('1')->where('published_at', '<=', date('Y-m-d'));
    }

    public function showByAmount($num = 4)
    {
        return $this->makeFrontendQuery()->take($num)->get();
    }

}