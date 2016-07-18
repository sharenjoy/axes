<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class LabelList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        if (isset($config['relation']))
        {
            foreach ($item->$config['relation'] as $value)
            {
                $content .= '<div class="label label-secondary">'.$value[$column].'</div>';
            }
        }
        else
        {
            $content .= '<div class="label label-secondary">'.$item[$column].'</div>';
        }

        $content .= '</td>';

        return $content;
    }

}

