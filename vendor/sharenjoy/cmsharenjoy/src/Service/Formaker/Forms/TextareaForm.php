<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class TextareaForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '<textarea'.$attributes.'>'.e($data['value']).'</textarea>';
        
        return $form;
    }

}