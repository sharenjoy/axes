<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class WysiwygAdvancedForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control wysiwyg-advanced';

        $attributes = $this->attributes($data);
        
        $form = '<textarea'.$attributes.'>'.e($data['value']).'</textarea>';

        set_package_asset_to_view('ckeditor');
        
        return $form;
    }

}