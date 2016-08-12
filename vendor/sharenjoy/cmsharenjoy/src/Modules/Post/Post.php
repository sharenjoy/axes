<?php

namespace Sharenjoy\Cmsharenjoy\Modules\Post;

use Sharenjoy\Cmsharenjoy\Filer\AlbumTrait;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;
use Sharenjoy\Cmsharenjoy\Modules\Tag\TaggableTrait;

class Post extends EloquentBaseModel
{
    use AlbumTrait, TaggableTrait;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'status_id',
        'title',
        'slug',
        'content',
        'sort'
    ];

    protected $eventItem = [
        'creating'    => ['user_id', 'status_id', 'slug|title', 'sort'],
        'created'     => ['album'],
        'updating'    => ['user_id', 'status_id', 'slug|title'],
        'saved'       => ['syncToTags'],
        'deleted'     => [],
    ];

    public $filterFormConfig = [
        'keyword'     => ['order'=>'10', 'filter' => 'posts.title,posts.content'],
    ];

    public $formConfig = [
        'title'       => ['order' => '10'],
        'tag'         => ['order' => '20', 'type'=>'selectMulti', 'relation'=>'fieldTags', 'args'=>['name'=>'tag[]']],
        'album'       => ['order' => '28', 'create'=>'deny', 'update'=>[]],
        'content'     => ['order' => '30', 'inner-div-class'=>'col-sm-9'],
    ];

    public function fieldTags($id)
    {
        $content['value'] = $id != '' ? $this->find($id)->tags->implode('id', ',') : '';
        $content['option'] = $this->grabTagLists()->toArray();

        return $content;
    }

    public function eventSyncToTags($key, $model)
    {
        if ( ! isset(self::$inputData['tag'])) return;

        if (empty(self::$inputData['tag']))
        {
            return $model->tags()->detach();
        }

        $data = explode(',', self::$inputData['tag']);
        
        return $model->tags()->sync($data);
    }

}