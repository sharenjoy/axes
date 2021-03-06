<?php

namespace App\Modules\Tag;

use Config, DB;
use Illuminate\Support\Str;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;
use Sharenjoy\Cmsharenjoy\Utilities\CmsharenjoyString;

class Tag extends EloquentBaseModel
{
    protected $table = 'tags';

    protected $fillable = [
        'type',
        'tag',
        'count'
    ];

    protected $eventItem = [];

    public $filterFormConfig = [
        'type'      => ['order'=>'10', 'type' => 'select', 'option'=>'tag_type', 'pleaseSelect'=>true],
        'keyword'   => ['order'=>'20', 'filter' => 'tags.tag'],
    ];

    public $formConfig = [
        'type'    => ['type'=>'select',  'order' => '5', 'option'=>'tag_type', 'pleaseSelect'=>true],
        'tag'     => ['type'  => 'text', 'order' => '10'],
        'count'   => ['type'  => 'text', 'order' => '20', 'value' => 0],
    ];

    public function listQuery()
    {
        return $this->orderBy('count', 'DESC')->orderBy('updated_at', 'DESC');
    }
    
    public function setTagAttribute($value)
    {
        $this->attributes['tag'] = Str::title(CmsharenjoyString::slug(trim($value)));
    }

    public function scopeSuggested($query)
    {
        return $query->where('suggest', true);
    }

    public function scopeType($query, $value)
    {
        return $value ? $query->where('type', $value) : $query;
    }

    public static function withCalculate()
    {
        return static::join('taggables', 'taggables.tag_id', '=', 'tags.id')
                    ->groupBy('tags.tag')
                    ->get(['tags.tag', DB::raw('count(*) as count')]);
    }

    public static function withAllRelation()
    {
        $taggableModel = Config::get('module.tag.taggableModel');
        
        $keys = array_keys($taggableModel);

        return static::with($keys);
    }

    public function __call($method, $parameters)
    {
        $taggableModel = Config::get('module.tag.taggableModel');

        if (array_key_exists($method, $taggableModel))
        {
            return $this->morphedByMany($taggableModel[$method], 'taggable');
        }

        return parent::__call($method, $parameters);
    }

    public function grabTagtypeLists()
    {
        return trans_options('options.tag_type');
    }

}