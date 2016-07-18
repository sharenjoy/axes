<?php namespace Sharenjoy\Cmsharenjoy\Filer;

use Sharenjoy\Cmsharenjoy\Utilities\Transformer;
use Event, Filer;

trait AlbumTrait {

    public function album()
    {
        return $this->belongsTo('Sharenjoy\Cmsharenjoy\Filer\Folder', 'album_id');
    }

    public function eventAlbum($key, $model)
    {
        $title = Transformer::title($model->toArray());

        $result = Filer::createFolder(0, $title, 'local', '', 1);
        $model->album_id = $result['data']['id'];
        $model->save();
    }

}