<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Sharenjoy\Organization\Models\Department;

class EmployeeForm extends FormAbstract implements FormInterface {

    public function make(array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'select2';
        $data['data-allow-clear'] = "true";
        $data['data-placeholder'] = pick_trans('option.pleaseSelect');
        
        $attributes = $this->attributes($data);
        
        $options = Department::with('employees')->orderBy('sort')->get()->toArray();

        $form = '<select '.$attributes.'><option></option>';

        if (count($options))
        {
            foreach ($options as $department)
            {
                $form .= '<optgroup label='.e($department['name']).'>';
                foreach ($department['employees'] as $employee)
                {
                    $selected = $employee['id'] == $data['value'] ? ' selected' : null;
                    $form .= '<option value="'.e($employee['id']).'"'.$selected.'>'.e($employee['name']).' '.e($employee['name_en']).'</option>';
                }
                $form .= '</optgroup>';
            }
        }
        
        $form .= '</select>';

        // To add the asset of package to View
        set_package_asset_to_view('multi-select2');
        
        return $form;
    }

}
