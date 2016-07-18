<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Functions;

use Session;

class DeleteFunction extends FunctionAbstract implements FunctionInterface {

    public function make(array $data)
    {
        $content =
        '<li>
            <a href="#" class="tooltip-primary common_modal" data-toggle="tooltip" data-placement="top" title="'.pick_trans('buttons.delete').'" data-original-title="'.pick_trans('buttons.delete').'" data-type="delete" data-id="'.$data['item']['id'].'">
                <i class="fa fa-trash-o fa-lg"></i>
            </a>
        </li>';

        return $content;
    }

}
