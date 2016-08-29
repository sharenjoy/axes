<!-- Filemanager modal -->
@if(Session::get('onController') != 'filer')
  
  <div class="modal fade custom-width" id="modal-filemanager">
    <div class="modal-dialog" style="width:800px">
      <div class="modal-content">
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">{{pick_trans('menu.file')}}</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <iframe src="{{url($accessUrl.'/filer/filemanager')}}" id="iframe-modal-filemanager" width="100%" height="560" frameborder="0" scrolling="no"></iframe>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <input type="hidden" name="pick_field_name" id="pick_field_name" value="">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
        </div>
      </div>
    </div>
  </div>

  @if(isset($albumId))
    <div class="modal fade custom-width" id="modal-album">
      <div class="modal-dialog" style="width:800px">
        <div class="modal-content">
          
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{pick_trans('menu.album')}}</h4>
          </div>
          
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <iframe src="{{url($accessUrl.'/filer/filealbum/'.$albumId)}}" id="iframe-modal-file-album" width="100%" height="560" frameborder="0" scrolling="no"></iframe>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if(isset($fileAlbumId))
    <div class="modal fade custom-width" id="modal-file-album">
      <div class="modal-dialog" style="width:800px">
        <div class="modal-content">
          
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{pick_trans('menu.file')}}</h4>
          </div>
          
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <iframe src="{{url($accessUrl.'/filer/filealbum/'.$fileAlbumId)}}" id="iframe-modal-file-album" width="100%" height="560" frameborder="0" scrolling="no"></iframe>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
          </div>
        </div>
      </div>
    </div>
  @endif

@endif
<!-- Filemanager modal Ends -->