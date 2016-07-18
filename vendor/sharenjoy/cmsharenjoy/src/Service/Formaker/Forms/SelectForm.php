<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class SelectForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];
        
        $input = $data['value'];

        unset($data['value']);

        $attributes = $this->attributes($data);
        
        $form = '<select'.$attributes.'>';

        if (count($otherSetting['option']))
        {
            foreach ($otherSetting['option'] as $key => $value)
            {
                $selected = $key == $input ? ' selected' : null;
                $form .= '<option value="'.e($key).'"'.$selected.'>'.e($value).'</option>';
            }
        }
        
        $form .= '</select>';
        
        return $form;
    }

}