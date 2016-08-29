<?php namespace Sharenjoy\Cmsharenjoy\Filer;

use Sharenjoy\Cmsharenjoy\Utilities\Transformer;
use Event, Filer;

trait FilealbumTrait {

    public function filealbum()
    {
        return $this->belongsTo('Sharenjoy\Cmsharenjoy\Filer\Folder', 'filealbum_id');
    }

    public function eventFilealbum($key, $model)
    {
        $title = Transformer::title($model->toArray());

        $result = Filer::createFolder(0, $title, 'local', '', 1);
        $model->filealbum_id = $result['data']['id'];
        $model->save();
    }

    /**
     * Figure out if file album can be used on the model
     * @return boolean
     */
    public function isFileAlbumable()
    {
        return in_array(
            'Sharenjoy\Cmsharenjoy\Filer\FilealbumTrait',
            $this->getReflection()->getTraitNames()
        );
    }

}