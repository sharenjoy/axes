<?php

namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

use Sharenjoy\Cmsharenjoy\Service\Lister\Lists\ListAbstract;
use Sharenjoy\Cmsharenjoy\Service\Lister\Lists\ListInterface;

class PriceList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';
        
        $content .= number_format($item->{$column});
        
        $content .= '</td>';

        return $content;
    }

}
