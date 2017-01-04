<?php

namespace Sharenjoy\Cmsharenjoy\Utilities;

class Transformer
{
    public function __construct()
    {
        
    }

    // public function collection($collection)
    // {
    //     return array_map([$this, 'transform'], $collection->toArray());
    // }

    // public function transform($data)
    // {
    //     return [
    //         'title' => $data['title'],
    //         'action' => (boolean) $data['action'],
    //     ];
    // }

    public static function title($model)
    {
        $existsAry = ['title', 'name', 'subject', 'tag'];

        foreach ($existsAry as $value)
        {
            if (isset($model[$value])) {
                return $model[$value];
            } else {
                if (method_exists($model, 'getReflection')) {
                    return $model->getReflection()->getShortName().'-'.$model->id;
                }

                return get_class($model).'-'.$model->id;
            }
        }

        throw new \Exception("It doesn't match the variable of 'title'.");
    }

}
