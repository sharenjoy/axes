<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class HiddenForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '<input type="hidden"'.$attributes.'>';
        
        return $form;
    }

}