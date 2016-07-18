<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class LinkList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        if ($item->$column != '')
        {
            $content .= '<a href="'.$item[$column].'" target="_blank">'.pick_trans('linkto').'</a>';
        }
        else
        {
            $content .= '-';
        }
        
        $content .= '</td>';

        return $content;
    }

}
