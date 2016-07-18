<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class AlbumForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {        
        $form = '<button type="button" class="btn btn-info btn-lg btn-icon file-album-pick-open-manager">
                    '.pick_trans('buttons.open').'
                    <i class="entypo-picture"></i>
                </button>';

        return $form;
    }

}