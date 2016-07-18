<?php namespace Sharenjoy\Cmsharenjoy\Utilities;

class Transformer {
    
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

    public static function title(array $item)
    {
        $existsAry = ['title', 'name', 'subject', 'tag', 'sn'];

        foreach ($existsAry as $value)
        {
            if (array_key_exists($value, $item))
            {
                return $item[$value];
            }
        }

        throw new \Exception("It doesn't match the variable of 'title'.");
    }

}
