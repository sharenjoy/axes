<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class EmailForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '<input type="email"'.$attributes.'>';
        
        return $form;
    }

}