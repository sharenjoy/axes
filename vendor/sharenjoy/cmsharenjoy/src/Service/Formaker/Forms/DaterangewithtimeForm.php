<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class DaterangewithtimeForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control daterange daterange-inline add-ranges';

        $data['data-format']     = array_get($data, 'others.setting.args.data-format') ?: 'YYYY-MM-DD hh:mm:ss';
        $data['data-start-date'] = array_get($data, 'others.setting.args.data-start-date') ?: 
                                   date('Y-m-d', time() - 86400);
        $data['data-end-date']   = array_get($data, 'others.setting.args.data-end-date') ?: date('Y-m-d', time());
        $data['data-separator']  = array_get($data, 'others.setting.args.data-separator') ?: ' ~ ';
        $data['data-time-picker'] = "true";
        $data['data-time-picker-increment'] = "1";

        $attributes = $this->attributes($data);
        
        $form = '<div class="input-group"><div class="input-group-addon"><i class="entypo-calendar"></i></div>';
        $form .= '<input type="text"'.$attributes.'>';
        $form .= '</div>';

        set_package_asset_to_view('daterange');
        
        return $form;
    }

}
