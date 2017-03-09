<?php

namespace Sharenjoy\Cmsharenjoy\Service\Lister\Templates;

use Session, Form, Exception;

class GridTemplate extends TemplateAbstract implements TemplateInterface
{
    protected $data;
    protected $template = '
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading" style="padding: 8px 15px">
                        {pagination}
                    </div>
                    
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="row">
                           {body}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>';

    public function make(array $data)
    {
        $this->data = $data;

        $content['body']       = $this->body();
        $content['pagination'] = $this->pagination();
        $content['sortform']   = $this->sortform();
        $content['sortable']   = $data['data']['sortable'] === true ? ' id="sortable"' : '';
        
        return $this->parser->parse($this->template, $content);
    }

    protected function body()
    {
        $width = $this->mainTdWidth();
        
        $content = '';
        foreach($this->data['items'] as $item)
        {
            $content .= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" id="'.$item['id'].'" style="height: 280px"><div class="panel panel-default panel-shadow" data-collapsed="0"><div class="panel-heading"><div class="panel-title list-fun-box">'.$this->combineFunctions($item).'</div>';
            $content .= '<div class="panel-options">'.$this->getItemStatusElement($item).'</div></div>';
            $content .= '<div class="panel-body"><div class="scrollable" data-height="165" data-scroll-position="right" data-rail-color="#fff" data-rail-opacity=".9" data-rail-width="8" data-rail-radius="10" data-autohide="0">';

            $content .= $this->getItemContentStatusElement($item);

            $content .= '</div></div></div></div>';
        }

        return $content;
    }

    protected function getItemStatusElement($item)
    {
        if (isset($item['status_id'])) {
            if ($this->isItemStatusEnable($item)) {
                return '<div style="padding-top:13px">'.pick_trans('status').': <i class="fa fa-check text-success"></i> '.trans('option.enable').'</div>';
            }

            return '<div style="padding-top:13px">'.pick_trans('status').': <i class="fa fa-times text-danger"></i> '.trans('option.disable').'</div>';
        }
    }

    protected function getItemContentStatusElement($item)
    {
        if (isset($item['status_id'])) {
            if ($this->isItemStatusEnable($item)) {
                return '<div class="tile-stats tile-green"><div class="icon"><i class="entypo-play"></i></div>'.$this->combineLists($item).'</div>';
            }

            return '<div class="tile-stats tile-gray"><div class="icon"><i class="entypo-pause"></i></div>'.$this->combineLists($item).'</div>';
        }

        return '<div class="tile-stats tile-primary">'.$this->combineLists($item).'</div>';
    }

    protected function isItemStatusEnable($item)
    {
        if (! isset($item['status_id'])) {
            throw new Exception('There is no status_id.');
        }

        $play = false;
        if ($item['status_id'] == '1') {
            $play = true;
            if (isset($item['start_at']) && isset($item['end_at'])) {
                if (time() < $item['start_at']->timestamp || time() > $item['end_at']->timestamp) {
                    $play = false;
                }
            }
        }

        return $play;
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
