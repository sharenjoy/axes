<?php namespace App\Modules\Product;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class ProductRepository extends EloquentBaseRepository implements ProductInterface {
    
    public function __construct(Product $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
    }

}