<?php

namespace App\Modules\Carousel;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class CarouselRepository extends EloquentBaseRepository implements CarouselInterface
{    
    public function __construct(Carousel $model, ValidableInterface $validator)
    {
        $this->model     = $model;
        $this->validator = $validator;
    }

    public function showAllWithStatusTrue()
    {
        return $this->model->listQuery()->whereStatusId('1')->get();
    }

}