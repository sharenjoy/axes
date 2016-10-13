<?php

namespace App\Modules\Product;

use App\Modules\Tag\TaggableTrait;
use Sharenjoy\Cmsharenjoy\Filer\AlbumTrait;
use Sharenjoy\Cmsharenjoy\Filer\FilealbumTrait;
use Sharenjoy\Cmsharenjoy\Utilities\Transformer;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;

class Product extends EloquentBaseModel
{
    use TaggableTrait, AlbumTrait, FilealbumTrait;

    protected $table = 'products';

    protected $fillable = [
        'user_id',
        'category_id',
        'status_id',
        'title',
        'content',
        'video',
        'img',
        'specification',
        'pnb_key_serialize',
        'pnb_value_serialize',
        'pnb_price_serialize',
        'price_range_start_serialize',
        'price_range_end_serialize',
        'price_discount_serialize',
        'sort'
    ];

    protected $eventItem = [
        'creating'    => ['user_id', 'sort'],
        'created'     => ['album', 'filealbum'],
        'updating'    => ['user_id'],
        'saved'       => ['syncToTags'],
        'deleted'     => [],
    ];

    public $filterFormConfig = [
        'status'      => ['order'=>'10', 'option'=>'status', 'pleaseSelect'=>true],
        'keyword'     => ['order'=>'20', 'filter' => 'products.title,products.content,products.specification'],
    ];

    public $formConfig = [
        'title'         => ['order' => '10'],
        'category_id'   => ['order' => '20', 'category'=>'product', 'pleaseSelect'=>true],
        'img'           => ['order' => '30', 'size'=>'700x500'],
        'content'       => ['order' => '40', 'type' => 'textarea', 'args' => ['rows'=>'6']],
        'video'         => ['order' => '50', 'type' => 'youtube'],
        'tag'           => ['order' => '60', 'type'=>'selectMulti', 'relation'=>'fieldTags', 'args'=>['name'=>'tag[]']],
        'album'         => ['order' => '70', 'create'=>'deny'],
        'filealbum'     => ['order' => '80', 'create'=>'deny'],
        'specification' => ['order' => '90', 'type' => 'wysiwygAdvanced'],
        'pnb'           => [
            'order'    => '100',
            'create'=>[], 'update'=>[],
            'inner-div-class'=>'col-sm-7',
            'type'     => 'duplicate',
            'columns'  => [
                'pnb_key_serialize' => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'pnb_key_serialize[]']],
                'pnb_value_serialize'   => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'pnb_value_serialize[]']],
                'pnb_price_serialize' => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'pnb_price_serialize[]']],
            ],
            'relation'=>'fieldPnb',
        ],
        'discounts' => [
            'order'    => '110',
            'create'=>[], 'update'=>[],
            'inner-div-class'=>'col-sm-7',
            'type'     => 'duplicate',
            'columns'  => [
                'price_range_start_serialize' => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'price_range_start_serialize[]']],
                'price_range_end_serialize'   => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'price_range_end_serialize[]']],
                'price_discount_serialize'   => ['duplicate-inner-div-class' => 'col-md-4', 'args'=>['name'=>'price_discount_serialize[]']],
            ],
            'relation'=>'fieldPrice',
        ],
        'status_id'    => ['order' => '120', 'type'=>'radio', 'option'=>'status', 'value'=>'1'],
    ];

    public function grabTagLists()
    {
        return $this->tags()->getRelated()->where('type', 'product')->get()->lists('tag', 'id');
    }

    public function fieldPnb($id)
    {
        if (! $id) {
            return [];
        }

        $result = $this->handleSerializeFields($id, ['pnb_key_serialize', 'pnb_value_serialize', 'pnb_price_serialize']);

        return ['value' => $result];
    }

    public function fieldPrice($id)
    {
        if (! $id) {
            return [];
        }

        $result = $this->handleSerializeFields($id, ['price_range_start_serialize', 'price_range_end_serialize', 'price_discount_serialize']);

        return ['value' => $result];
    }

    protected function handleSerializeFields($id, array $columns)
    {
        $prices = array_only($this->find($id)->toArray(), $columns);
        $result = [];

        foreach ($prices as $key => $value) {
            $ary = unserialize($value);

            if (count($ary) && $ary !== false) {
                foreach ($ary as $k => $item) {
                    $result[$k][$key] = $item;
                }
            }
        }

        return $result;
    }

}