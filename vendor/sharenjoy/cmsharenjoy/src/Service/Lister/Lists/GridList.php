<?php

namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class GridList extends ListAbstract implements ListInterface
{
    public function make($item, $column, $config)
    {
        $content = $config['start'];

        if (isset($config['relations'])) {
            $content .= array_get($item->toArray(), $config['relations']);
        } else {
            if (isset($config['lists']) && session()->has('allLists.'.$config['lists'])) {
                if ($item[$column]) {
                    $content .= array_get(session()->get('allLists.'.$config['lists']), $item[$column]);
                } else {
                    $content .= '-';
                }
            } else {
                $content .= $item[$column];
            }
        }

        $content .= $config['end'];

        return $content;
    }

}