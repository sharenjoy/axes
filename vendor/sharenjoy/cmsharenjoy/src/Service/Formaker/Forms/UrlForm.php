<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class UrlForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $attributes = $this->attributes($data);
        
        $form = '<input type="url"'.$attributes.'>';
        
        return $form;
    }

}