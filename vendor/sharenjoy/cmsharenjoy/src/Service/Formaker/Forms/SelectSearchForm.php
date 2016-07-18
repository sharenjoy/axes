<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class SelectSearchForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'select2';
        
        $otherSetting = $data['others'];
        
        $attributes = $this->attributes($data);
        
        $form = '<select'.$attributes.'data-allow-clear="true" data-placeholder="'.pick_trans('option.pleaseSelect').'">';
        $form .= '<option></option>';

        if (count($otherSetting['option']))
        {
            foreach ($otherSetting['option'] as $key => $value)
            {
                $selected = $key == $data['value'] ? ' selected' : null;
                $form .= '<option value="'.e($key).'"'.$selected.'>'.e($value).'</option>';
            }
        }
        
        $form .= '</select>';

        // To add the asset of package to View
        set_package_asset_to_view('multi-select2');
        
        return $form;
    }

}
