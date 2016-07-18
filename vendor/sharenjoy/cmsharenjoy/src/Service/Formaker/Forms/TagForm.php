<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class TagForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control tagsinput';

        $attributes = $this->attributes($data);
        
        $form = '<input type="text"'.$attributes.'>';

        // To add the asset of package to View
        set_package_asset_to_view('tag');
        
        return $form;
    }

}