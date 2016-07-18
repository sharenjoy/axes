<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class ImageList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        if ($item->$column != '')
        {
            if (isset($config['imageWidth']))
            {
                $content .= '<img src="'.asset('uploads/'.$item[$column]).'" width="'.$config['imageWidth'].'">';
            }
            else
            {
                $content .= '<img src="'.asset('uploads/thumbs/'.$item[$column]).'" width="75">';
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

