<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Functions;

use Session;

class SendmessageFunction extends FunctionAbstract implements FunctionInterface {

    public function make(array $data)
    {
        $content =
        '<li>
            <a href="'.Session::get('objectUrl').'/sendmessage/'.$data['item']['id'].'" class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="'.pick_trans('buttons.sendmessage').'" data-original-title="'.pick_trans('buttons.sendmessage').'">
                <i class="fa fa-phone fa-lg"></i>
            </a>
        </li>';

        return $content;
    }

}
