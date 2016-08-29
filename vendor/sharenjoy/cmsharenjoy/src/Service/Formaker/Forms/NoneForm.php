<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class NoneForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '';
        
        return $form;
    }

}