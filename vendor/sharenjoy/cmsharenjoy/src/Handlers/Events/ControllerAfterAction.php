<?php namespace Sharenjoy\Cmsharenjoy\Handlers\Events;

use Session, Filer;

class ControllerAfterAction {
    
    public function handle($data)
    {
        switch (Session::get('onMethod'))
        {
            case 'get-index':
                Session::forget('allLists');
                break;

            case 'get-update':
                $this->outputAlbumIdToView($data);
                $this->outputFilealbumIdToView($data);
                break;

            case 'post-delete':
                $this->deleteAlbum($data);
                $this->deleteFileAlbum($data);
                break;
            
            default:
                break;
        }
    }

    private function outputAlbumIdToView($data)
    {
        if ($data->album_id && $data->isAlbumable())
        {
            view()->share('albumId', $data->album_id);
        }
    }

    private function outputFilealbumIdToView($data)
    {
        if ($data->filealbum_id && $data->isFileAlbumable())
        {
            view()->share('fileAlbumId', $data->filealbum_id);
        }
    }

    private function deleteAlbum($data)
    {
        if ($data->isAlbumable())
        {
            Filer::deleteFolderDoNotConfirm($data->album_id);
        }
    }

    private function deleteFileAlbum($data)
    {
        if ($data->isFileAlbumable())
        {
            Filer::deleteFolderDoNotConfirm($data->filealbum_id);
        }
    }

}