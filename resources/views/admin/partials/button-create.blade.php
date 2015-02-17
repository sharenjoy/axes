{!!Form::reset(pick_trans('buttons.reset'), array('class'=>'btn btn-large btn-default'))!!}
&nbsp;
{!!Form::submit(pick_trans('buttons.create'), array('class'=>'btn btn-large btn-success'))!!}
&nbsp;
{!!Form::button(pick_trans('buttons.create_exit'), array('class'=>'btn btn-large btn-blue', 'data-type'=>'exit'))!!}
&nbsp;
{!!Form::button(pick_trans('buttons.cancel'), ['class'=>'btn btn-large btn-danger', 'onclick'=>'location.href="'.Session::get('goBackPrevious').'"'])!!}
