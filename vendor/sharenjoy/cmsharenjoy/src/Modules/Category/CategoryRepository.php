<?php namespace Sharenjoy\Cmsharenjoy\Modules\Category;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;
use Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\Category;
use Message;

class CategoryRepository extends EloquentBaseRepository implements CategoryInterface {

    // Class expects an Eloquent model
    public function __construct(Category $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
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