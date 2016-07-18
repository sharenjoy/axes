<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Templates;

use Session, Form;

class DefaultTemplate extends TemplateAbstract implements TemplateInterface {
    
    protected $data;

    protected $template = '<table class="table table-bordered table-hover table-responsive"{sortable}>
                               {thead}
                               {tbody}
                               {tfoot}
                           </table>
                           {pagination}
                           {sortform}';

    public function make(array $data)
    {
        $this->data = $data;

        $content['thead']      = $this->thead();
        $content['tbody']      = $this->tbody();
        $content['tfoot']      = $this->tfoot();
        $content['pagination'] = $this->pagination();
        $content['sortform']   = $this->sortform();
        $content['sortable']   = $data['data']['sortable'] === true ? ' id="sortable"' : '';
        
        return $this->parser->parse($this->template, $content);
    }

    protected function thead()
    {
        $content = '<thead><tr><th>&nbsp;</th>';
        
        foreach($this->data['listConfig'] as $item)
        {
            $content .= '<th align="center">'.pick_trans($item['name']).'</th>';
        }

        $content .= '</tr></thead>';

        return $content;
    }

    protected function tbody()
    {
        $width = $this->mainTdWidth();
        
        $content = '<tbody>';        
        foreach($this->data['items'] as $item)
        {
            $content .= '<tr id="'.$item['id'].'"><td width="'.$width.'"><div class="list-fun-box">';
            $content .= $this->combineFunctions($item);
            $content .= '</div></td>';
            $content .= $this->combineLists($item);
            $content .= '</tr>';
        }
        $content .= '</tbody>';

        return $content;
    }

    protected function tfoot()
    {
        $content = '';
        $paginationCount = $this->data['data']['paginationCount'];
        $count = count($this->data['items']);

        if($count < $paginationCount)
        {
            $content = '<tfoot>';
            for ($i=0; $i < $paginationCount - $count; $i++)
            {
                $content .= '<tr><td>&nbsp;</td>';
                foreach ($this->data['listConfig'] as $item)
                {
                    $content .= '<td>&nbsp;</td>';
                }
                $content .= '</tr>';
            }
            $content .= '</tfoot>';
        }

        return $content;
    }

    protected function pagination()
    {
        $content = '<div class="row"><div class="'.$this->data['config']['pagecount-div-class'].'"><div class="dataTables_info">';
        $content .= Form::open(['method'=>'get', 'role'=>'form', 'id'=>'pagination_count_form']);
        $content .= Form::select(
                        'perPage', 
                        ['10'=>'10', '15'=>'15', '20'=>'20', '30'=>'30', '50'=>'50'],
                        $this->data['data']['paginationCount'],
                        ['class'=>'form-control pagination_count', 'id'=>'pagination_count']);

        if ($_SERVER['QUERY_STRING'] != '')
        {
            $content .= Form::hidden('query_string', $_SERVER['QUERY_STRING']);
        }
        // dd($this->data['items']);
        $content .= '&nbsp;&nbsp;'.pick_trans('pagination_desc', ['from'=>$this->data['items']->firstItem(), 'to'=>$this->data['items']->lastItem(), 'total'=>$this->data['items']->total()]);
        $content .= Form::close();
        $content .= '</div></div><div class="'.$this->data['config']['pagination-div-class'].'"><div class="dataTables_paginate paging_bootstrap">'.$this->data['items']->render().'</div></div></div>';

        return $content;
    }

    protected function sortform()
    {
        $content = '';

        if ($this->data['data']['sortable'] === true)
        {
            $content = '<form id="sortform" name="sortform">';
            
            foreach($this->data['items'] as $item)
            {
                $content .= '<input type="hidden" value="'.$item->sort.'" />';
            }

            $content .= '</form>';
        }

        return $content;
    }

}
