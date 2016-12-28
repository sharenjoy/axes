<?php namespace Sharenjoy\Cmsharenjoy\Setting;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class SettingRepository extends EloquentBaseRepository implements SettingInterface {

    public function __construct(Setting $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
    }

    /**
     * Examine the key exists or not
     * @param  string  $key
     * @return boolean
     */
    public function has($key)
    {
        $model = $this->model->where('key', $key)->first();
        
        return isset($model->value) ? true : false;
    }

    /**
     * Get a setting by it's key or slug or whatever
     * @param  mix $key The key (contact-address , website-name etc)
     * @return One God-Damn Record
     */
    public function get($key)
    {
        if (is_array($key))
        {
            $result = $this->model->where(function($query) use ($key){
                for ($i=0; $i < count($key); $i++)
                {
                    $query->orWhere('key', $key[$i]);
                }
            })->get()->lists('value', 'key');
        }
        elseif(is_string($key))
        {
            $model = $this->model->where('key', $key)->first();
            $result = $model->value;
        }

        return $result;
    }

    /**
     * get all the items sort by module
     * @return array
     */
    public function all()
    {
        $items = $this->model->orderBy('sort')->get()->groupBy('module')->all();

        foreach ($items as $key => $item) {
            $items[$key] = $item->pluck('value', 'key')->toArray();
        }

        return $items;
    }

}