<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Lists;

class CommonList extends ListAbstract implements ListInterface {

    public function make($item, $column, $config)
    {
        $content = '<td align="'.$config['align'].'" width="'.$config['width'].'">';

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

        $content .= '</td>';

        return $content;
    }

}