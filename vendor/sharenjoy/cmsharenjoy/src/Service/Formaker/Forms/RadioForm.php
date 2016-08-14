<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class RadioForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];

        $option = $otherSetting['option'];

        $name = $data['name'];
        $value = $data['value'];

        $attributes = $this->attributes(array_except($data, ['other', 'name', 'value', 'class']));

        if ( ! is_array($value)) $value = explode(',', (string)$value);

        $form = null;

        foreach ($option as $optionKey => $optionValue)
        {
            $form .= '<div class="radio"><label>';

            $checked = in_array($optionKey, $value) ? ' checked' : null;
            $form .= '<input type="radio" name="'.e($name).'" value="'.e($optionKey).'"'.$checked.$attributes.'>';
            $form .= e($optionValue);
            $form .= '</label></div>';
        }
        
        return $form;
    }

}
