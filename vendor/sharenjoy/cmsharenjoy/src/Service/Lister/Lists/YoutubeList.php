<?php

namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class YoutubeList extends ListAbstract implements ListInterface
{
    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        if ($item->{$column}) {
            $content .= '<img src="http://img.youtube.com/vi/'.$item->{$column}.'/3.jpg" width="75">';
        } else {
            $content .= '-';
        }
        
        $content .= '</td>';

        return $content;
    }
}

