<?php

namespace App\Modules\Category;

use Message;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class CategoryRepository extends EloquentBaseRepository implements CategoryInterface
{
    // Class expects an Eloquent model
    public function __construct(Category $model, ValidableInterface $validator)
    {
        $this->model     = $model;
        $this->validator = $validator;
    }

    /**
     * Create a new Article
     * @param array  Data to create a new object
     * @return string The insert id
     */
    public function create()
    {
        $model = $this->model->create($this->getInput());
        $model->makeRoot();

        // make sort
        $this->edit($model->id, ['sort' => $model->id]);

        return $model;
    }

}