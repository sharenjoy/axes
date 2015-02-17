<div class="col-xs-5 col-sm-5 col-left">
    <div class="dataTables_info">
        {{Form::open(array('method'=>'get', 'role'=>'form', 'id'=>'pagination_count_form'))}}
            {{Form::select(
                'perPage', 
                array(
                    '10' => '10',
                    '15' => '15',
                    '20' => '20',
                    '30' => '30',
                    '50' => '50'), 
                $paginationCount,
                array('class'=>'form-control pagination_count', 'id'=>'pagination_count')
            )}}
            {{$_SERVER['QUERY_STRING'] != '' ? Form::hidden('query_string', $_SERVER['QUERY_STRING']) : ''}}
            &nbsp;&nbsp;
            {{pick_trans('pagination_desc', array('from'=>$items->getFrom(), 'to'=>$items->getTo(), 'total'=>$items->getTotal()))}}
        {{Form::close()}}
    </div>
</div>
<div class="col-xs-7 col-sm-7 col-right">
    <div class="dataTables_paginate paging_bootstrap">
        {{$items->links()}}
    </div>
</div>