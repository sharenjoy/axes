<?php namespace Sharenjoy\Cmsharenjoy\Core\Traits;

trait AuthorModelTrait {

    public function author()
    {
        return $this->belongsTo('Sharenjoy\Cmsharenjoy\User\User', 'user_id');
    }

    public function getUsernameAttribute()
    {
        return isset($this->author->name) ? $this->author->name : '';
    }

}