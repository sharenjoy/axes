<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class SelectMultiListForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control multi-select';
        
        $otherSetting = $data['others'];
        
        $data['value'] = is_array($data['value']) ? join(',', $data['value']) : $data['value'];

        $attributes = $this->attributes($data);
        
        $form = '<select multiple="multiple"'.$attributes.'>';

        if (count($otherSetting['option']))
        {
            $valueAry = explode(',', $data['value']);
            foreach ($otherSetting['option'] as $key => $value)
            {
                $selected = in_array($key, $valueAry) ? ' selected' : null;
                $form .= '<option value="'.e($key).'"'.$selected.'>'.e($value).'</option>';
            }
        }
        
        $form .= '</select>';

        // To add the asset of package to View
        set_package_asset_to_view('multi-select-list');
        
        return $form;
    }

}
