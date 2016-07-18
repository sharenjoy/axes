<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class RadioForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];

        $option = $otherSetting['option'];

        $name = $data['name'];
        $value = $data['value'];

        if ( ! is_array($value)) $value = explode(',', (string)$value);

        $form = null;

        foreach ($option as $optionKey => $optionValue)
        {
            $form .= '<div class="radio"><label>';

            $checked = in_array($optionKey, $value) ? ' checked' : null;
            $form .= '<input type="radio" name="'.e($name).'" value="'.e($optionKey).'"'.$checked.'>';
            $form .= e($optionValue);
            $form .= '</label></div>';
        }
        
        return $form;
    }

}
