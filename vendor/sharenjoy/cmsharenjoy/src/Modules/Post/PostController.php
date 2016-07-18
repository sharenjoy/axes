<?php namespace Sharenjoy\Cmsharenjoy\Modules\Post;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class PostController extends ObjectBaseController {

    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'order'  => true,
    ];

    protected $listConfig = [
        'title'        => ['name'=>'title',        'align'=>'',       'width'=>''   ],
        'tag'          => ['name'=>'tag', 'type'=>'label', 'relation'=>'tags',   'align'=>'',       'width'=>''   ],
        'created_at'   => ['name'=>'created',      'align'=>'center', 'width'=>'20%'],
    ];

    public function __construct(PostInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

}