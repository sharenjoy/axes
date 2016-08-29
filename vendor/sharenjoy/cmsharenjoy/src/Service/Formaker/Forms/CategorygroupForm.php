<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Categorize;

class CategorygroupForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];
        $categoryType = array_get($otherSetting['setting'], 'category');
        $categoryLayer = config("module.category.layer.$categoryType");
        $attributes = $this->attributes($data);

        $categories = Categorize::getCategoryProvider()->root()
                                                       ->whereType($categoryType)
                                                       ->orderBy('sort', 'asc')
                                                       ->get();

        $option = Categorize::tree($categories)->lists('title', 'id');

        $form = '<select'.$attributes.'><option value="0">'.pick_trans('option.pleaseSelect').'</option>';

        if ($categoryLayer === 2) {
            if (count($option)) {
                foreach ($option as $key => $value) {
                    $category = Categorize::getCategoryProvider()->whereType($categoryType)->whereTitle($value)->first()->getChildren()->toArray();
                    $optgroup = $this->getSelectOptgroup($category['title']);
                    if (isset($category['children']) && count($category['children']) > 0) {
                        $form .= sprintf($optgroup, $this->getSelectOption($data, array_pluck($category['children'], 'title', 'id')));
                    } else {
                        $form .= $optgroup;
                    }
                }
            }
        } else {
            $form .= $this->getSelectOption($data, $option);
        }
        
        $form .= '</select>';
        
        return $form;
    }

    private function getSelectOptgroup($value)
    {
        return '<optgroup label="'.e($value).'">%s</optgroup>';
    }

    private function getSelectOption($data, $option)
    {
        $string = '';

        if (count($option)) {
            foreach ($option as $key => $value) {
                $selected = $key == $data['value'] ? ' selected' : null;
                $string .= '<option value="'.e($key).'"'.$selected.'>'.e($value).'</option>';
            }
        }

        return $string;
    }

}
