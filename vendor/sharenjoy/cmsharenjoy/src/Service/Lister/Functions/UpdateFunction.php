<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Functions;

use Session;

class UpdateFunction extends FunctionAbstract implements FunctionInterface {

    public function make(array $data)
    {
        $content =
        '<li>
            <a href="'.Session::get('objectUrl').'/update/'.$data['item']['id'].'" class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="'.pick_trans('buttons.edit').'" data-original-title="'.pick_trans('buttons.edit').'">
                <i class="fa fa-pencil-square-o fa-lg"></i>
            </a>
        </li>';

        return $content;
    }

}
