<?php namespace Sharenjoy\Cmsharenjoy\Modules\Tag;

use Illuminate\Support\Str;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;
use Sharenjoy\Cmsharenjoy\Utilities\CmsharenjoyString;
use Config, DB;

class Tag extends EloquentBaseModel {

    protected $table = 'tags';

    protected $fillable = [
        'tag',
        'count'
    ];

    protected $eventItem = [];

    public $filterFormConfig = [];

    public $formConfig = [
        'tag'          => ['type'  => 'text', 'order' => '10'],
        'count'        => ['type'  => 'text', 'order' => '20']
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

}