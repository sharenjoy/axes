<!-- Common model Starts -->
<div class="modal fade" id="common-modal">
  <form action="" method="POST">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="common-modal-title"></h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12" id="common-modal-body"></div>
          </div>
        </div>
        
        <div class="modal-footer">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.cancel')}}</button>
          {!!Form::button(pick_trans('buttons.confirm'), ['type'=>'submit', 'class'=>"btn btn-info"])!!}
        </div>
      </div>
    </div>
  </form>
</div>
<!-- Common model Ends -->