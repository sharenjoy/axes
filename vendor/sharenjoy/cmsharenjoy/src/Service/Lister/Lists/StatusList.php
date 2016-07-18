<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class StatusList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        if ($item->$column)
        {
            if ($item->$column == 1)
            {
                $content .= '<i class="fa fa-check text-success"></i><br>'.trans('option.enable');
            }
            elseif ($item->$column == 2)
            {
                $content .= '<i class="fa fa-times text-danger"></i><br>'.trans('option.disable');

            }
        }
        else
        {
            $content .= '-';
        }
        
        $content .= '</td>';

        return $content;
    }

}
