<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Functions;

use Session;

class RemindpasswordFunction extends FunctionAbstract implements FunctionInterface {

    public function make(array $data)
    {
        $content =
        '<li>
            <a href="'.Session::get('objectUrl').'/remindpassword/'.$data['item']['id'].'" class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="'.pick_trans('buttons.remindpassword').'" data-original-title="'.pick_trans('buttons.remindpassword').'">
                <i class="fa fa-shield fa-lg"></i>
            </a>
        </li>';

        return $content;
    }

}
