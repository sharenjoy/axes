<?php namespace Sharenjoy\Cmsharenjoy\Modules\Tag;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class TagController extends ObjectBaseController {

    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'order'  => false,
    ];

    protected $listConfig = [
        'tag'          => ['name'=>'tag',          'align'=>'',       'width'=>''   ],
        'count'        => ['name'=>'quantity',     'align'=>'right',  'width'=>'10%'],
        'created_at'   => ['name'=>'created',      'align'=>'center', 'width'=>'20%'],
    ];

    public function __construct(TagInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

}