<?php namespace Sharenjoy\Cmsharenjoy\Core\Traits;

trait ScopeModelTrait {

    public function scopeStatus($query, $value)
    {
        return $value ? $query->where('status_id', $value) : $query;
    }

    public function scopeUserId($query, $value)
    {
        return $value ? $query->where('user_id', $value) : $query;
    }

    public function scopeCategoryId($query, $value)
    {
        return $value ? $query->where('category_id', $value) : $query;
    }

    public function scopeKeyword($query, $value)
    {
        if ($value)
        {
            $filter = array_get($this->filterFormConfig, 'keyword.filter');
            $fields = explode(',', $filter);
            
            return $query->where(function($query) use ($value, $fields)
            {
                foreach ($fields as $field)
                {
                    $query->orWhere($field, 'LIKE', "%$value%");
                }
            });
        }
        else
        {
            return $query;
        }
    }

}