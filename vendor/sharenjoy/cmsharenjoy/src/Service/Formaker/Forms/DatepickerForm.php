<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class DatepickerForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control datepicker';

        // 'data-format'        => 'yyyy-mm-dd',
        // 'data-start-date'    => '-2d',
        // 'data-end-date'      => '+1w',
        // 'data-disabled-days' => '1,3',
        // 'data-start-view'    => '2',
        $data['data-format'] = array_get($data, 'others.setting.args.data-format') ?: 
                               'yyyy-mm-dd';

        $attributes = $this->attributes($data);
        
        $form = '<div class="input-group"><div class="input-group-addon"><i class="entypo-calendar"></i></div>';
        $form .= '<input type="text"'.$attributes.'>';
        $form .= '</div>';

        set_package_asset_to_view('datepicker');
        
        return $form;
    }

}