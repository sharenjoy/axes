<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Functions;

use Session;

class PreviewFunction extends FunctionAbstract implements FunctionInterface {

    public function make(array $data)
    {
        $content =
        '<li>
            <a href="'.Session::get('objectUrl').'/preview/'.$data['item']['id'].'" class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="'.pick_trans('buttons.preview').'" data-original-title="'.pick_trans('buttons.preview').'">
                <i class="fa fa-search-minus fa-lg"></i>
            </a>
        </li>';

        return $content;
    }

}
