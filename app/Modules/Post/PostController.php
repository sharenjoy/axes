<?php

namespace App\Modules\Post;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class PostController extends ObjectBaseController
{
    protected $functionRules = [
        'list'   => true,
        'create' => true,
        'update' => true,
        'delete' => true,
        'order'  => true,
    ];

    protected $listConfig = [
        'title'        => ['name'=>'title',      'align'=>'',        'width'=>''],
        'tag'          => ['name'=>'tag',        'align'=>'',        'width'=>'',    'type'=>'label', 'relation'=>'tags'],
        'type'         => ['name'=>'type',       'align'=>'center',  'width'=>'120', 'lists' => 'post.posttype'],
        'img'          => ['name'=>'image',      'align'=>'center',  'width'=>'80',  'type'=>'image'],
        'video'        => ['name'=>'video',      'align'=>'center',  'width'=>'80',  'type'=>'youtube'],
        'status_id'    => ['name'=>'status',     'align'=>'center',  'width'=>'80',  'type'=>'status'],
        'published_at' => ['name'=>'published',  'align'=>'center',  'width'=>'140'],
        'updated_at'   => ['name'=>'updated',    'align'=>'center',  'width'=>'140'],
    ];

    public function __construct(PostInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

}