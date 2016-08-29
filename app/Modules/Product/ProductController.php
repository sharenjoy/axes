<?php namespace App\Modules\Product;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class ProductController extends ObjectBaseController {

    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'order'  => true,
    ];

    protected $listConfig = [
        'title'        => ['name'=>'title',       'align'=>'',       'width'=>''   ],
        'status_id'    => ['name'=>'status', 'type'=>'status', 'align'=>'center', 'width'=>'80'   ],
        'img'          => ['name'=>'image', 'type'=>'image', 'align'=>'', 'width'=>'80'   ],
        'updated_at'   => ['name'=>'updated',      'align'=>'center', 'width'=>'140'],
    ];

    public function __construct(ProductInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

}