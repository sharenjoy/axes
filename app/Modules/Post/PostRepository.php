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

    public function makeQuery($method = 'listQuery', $model = null)
    {
        $model = $model ?: $this->model;
        
        return $model->$method()->with('tags');
    }

}