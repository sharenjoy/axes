<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class ColorpickerForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control colorpicker';

        $data['data-format'] = array_get($data, 'others.setting.args.data-format') ?: 'hex';

        $attributes = $this->attributes($data);
        
        $form = '<div class="input-group"><div class="input-group-addon"><i class="color-preview"></i></div>';
        $form .= '<input type="text"'.$attributes.'>';
        $form .= '</div>';

        set_package_asset_to_view('colorpicker');
        
        return $form;
    }

}
