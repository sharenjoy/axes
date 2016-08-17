<?php

namespace App\Modules\Carousel;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class CarouselController extends ObjectBaseController
{
    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'order'  => true,
    ];

    protected $listConfig = [
        'title'        => ['name'=>'title',   'align'=>'',        'width'=>''],
        'type'         => ['name'=>'type',    'align'=>'center',  'width'=>'120', 'lists' => 'carousel.carouseltype'],
        'img'          => ['name'=>'image',   'align'=>'center',  'width'=>'80',  'type'=>'image'],
        'link'         => ['name'=>'link',    'align'=>'center',  'width'=>'80',  'type'=>'link'],
        'video'        => ['name'=>'video',   'align'=>'center',  'width'=>'80',  'type'=>'youtube'],
        'status_id'    => ['name'=>'status',  'align'=>'center',  'width'=>'80',  'type'=>'status'],
        'updated_at'   => ['name'=>'updated', 'align'=>'center',  'width'=>'140'],
    ];

    public function __construct(CarouselInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

}