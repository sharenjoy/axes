<?php

namespace App\Modules\Post;

use App\Modules\Tag\TaggableTrait;
use Sharenjoy\Cmsharenjoy\Filer\AlbumTrait;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;

class Post extends EloquentBaseModel
{
    use AlbumTrait, TaggableTrait;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'status_id',
        'type',
        'title',
        'img',
        'video',
        'slug',
        'content',
        'sort',
        'published_at',
    ];

    protected $eventItem = [
        'creating'    => ['user_id', 'slug|title', 'sort', 'selected_type'],
        'created'     => ['album'],
        'updating'    => ['user_id', 'slug|title', 'selected_type'],
        'saved'       => ['syncToTags'],
        'deleted'     => [],
    ];

    public $filterFormConfig = [
        'keyword'     => ['order'=>'10', 'filter' => 'posts.title,posts.content'],
    ];

    public $formConfig = [
        'title'       => ['order' => '10'],
        'tag'         => ['order' => '20', 'type'=>'selectMulti', 'relation'=>'fieldTags', 'args'=>['name'=>'tag[]']],
        'type'        => ['order' => '30', 'type' => 'radio', 'option' => 'post_type', 'args' => ['@click'=>'changeType']],
        'img'         => ['order' => '40', 'outer-div' => ['class'=>'form-group', ':class'=>'{"animated fadeIn": animationStyle}', 'v-show'=>'imageShow'], 'size' =>'720x486'],
        'video'       => ['order' => '50', 'outer-div' => ['class'=>'form-group', ':class'=>'{"animated fadeIn": animationStyle}', 'v-show'=>'videoShow'], 'type' => 'youtube'],
        'album_notes'       => ['order' => '55', 'outer-div' => ['class'=>'form-group', ':class'=>'{"animated fadeIn": animationStyle}', 'v-show'=>'albumShow'], 'type' => 'none', 'update'=>'deny', 'help' => '新增後完成後相簿管理會於編輯頁面出現'],
        'album'       => ['order' => '60', 'outer-div' => ['class'=>'form-group', ':class'=>'{"animated fadeIn": animationStyle}', 'v-show'=>'albumShow'], 'create'=>'deny', 'help' => '建議圖片尺寸720x486'],
        'content'     => ['order' => '70', 'inner-div-class'=>'col-sm-9'],
        'published_at' => ['order' => '80', 'type' => 'datepicker'],
        'status_id'    => ['order' => '90', 'type' =>'radio', 'option'=>'status', 'value'=>'1'],
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

        if (empty(self::$inputData['tag'])) {
            return $model->tags()->detach();
        }

        $data = explode(',', self::$inputData['tag']);
        
        return $model->tags()->sync($data);
    }

    public function eventSelectedType($key, $model)
    {
        if ($model) {
            if ($model->type == 'image') {
                $model->video = null;
            } elseif ($model->type == 'video') {
                $model->img = null;
            } elseif ($model->type == 'album') {
                $model->img = null;
                $model->video = null;
            }
        }
    }

    public function grabPosttypeLists()
    {
        return trans_options('options.post_type');
    }

    public function grabTagLists()
    {
        return $this->tags()->getRelated()->where('type', 'post')->get()->lists('tag', 'id');
    }

    public function listQuery()
    {
        return $this->orderBy('published_at', 'desc')->orderBy('sort', 'desc');
    }

}