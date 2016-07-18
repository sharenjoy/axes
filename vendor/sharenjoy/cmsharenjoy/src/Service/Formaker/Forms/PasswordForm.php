<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class PasswordForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '<input type="password"'.$attributes.'>';
        
        return $form;
    }

}