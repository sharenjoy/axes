<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Categorize;

class CategoryForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];
        $categoryType = array_get($otherSetting['setting'], 'category');

        $attributes = $this->attributes($data);

        $categories = Categorize::getCategoryProvider()->root()
                                                       ->whereType($categoryType)
                                                       ->orderBy('sort', 'asc')
                                                       ->get();
                                                       
        $option = array('0' => pick_trans('option.pleaseSelect')) +
                  Categorize::tree($categories)->lists('title', 'id');
        
        $form = '<select'.$attributes.'>';

        if (count($option))
        {
            foreach ($option as $key => $value)
            {
                $selected = $key == $data['value'] ? ' selected' : null;
                $form .= '<option value="'.e($key).'"'.$selected.'>'.e($value).'</option>';
            }
        }
        
        $form .= '</select>';
        
        return $form;
    }

}
