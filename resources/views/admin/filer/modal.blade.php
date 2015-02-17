<div class="modal fade custom-width" id="modal-new-folder">
    <form action="{{$objectUrl.'/newfolder/'.Session::get('onAction')}}" method="POST">
        <div class="modal-dialog" style="width: 650px;">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{pick_trans('files.role_create_folder')}}</h4>
                </div>
                
                <div class="modal-body">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                {!!Form::label('folder_name', pick_trans('files.folder_name'), array('class'=>'control-label'))!!}
                                {!!Form::text('folder_name', '', array('placeholder'=>pick_trans('files.folder_placeholder'), 'class'=>'form-control', 'id'=>'folder_name'))!!}
                            </div>  
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
                    {!!Form::button(pick_trans('buttons.create'), array('type'=>'submit', 'class'=>"btn btn-info"))!!}
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade custom-width" id="modal-create-file">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{pick_trans('files.role_upload')}}</h4>
            </div>
            
            <div class="modal-body">
            
                <div class="row" id="dropzone">
                    <div class="col-md-12">
                        
                        {!!Form::open(array('url'=>$objectUrl.'/upload', 'files'=>true, 'class'=>'dropzone', 'id'=>'dropzone_example'))!!}
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            {!!Form::hidden('parent_id', $parentId)!!}

                        {!!Form::close()!!}
                        
                    </div>
                </div>

                <h4 class="text-danger">{{pick_trans('files.uploader')}}</h4>
                
            </div>

            <div id="dze_info" class="hidden">
    
                <br />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">Dropzone Uploaded Files Info</div>
                    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="40%">File name</th>
                                <th width="15%">Size</th>
                                <th width="15%">Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.close')}}</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade custom-width" id="modal-file-detail">
    <div class="modal-dialog" style="width: 650px;">
        <form action="{{$objectUrl.'/updatefile/'.Session::get('onAction')}}" method="POST">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{pick_trans('files.role_edit_file')}}</h4>
                </div>
                
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!!Form::label('name', 'Name', array('class'=>'control-label'))!!}
                                {!!Form::text('name', '', array('placeholder'=>'Name', 'class'=>'form-control', 'id'=>'name'))!!}
                            </div>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!!Form::label('alt_attribute', 'Alt', array('class'=>'control-label'))!!}
                                {!!Form::text('alt_attribute', '', array('placeholder'=>'Alt', 'class'=>'form-control', 'id'=>'alt_attribute'))!!}
                            </div>  
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!!Form::label('description', 'Description', array('class'=>'control-label'))!!}
                                {!!Form::textarea('description', '', array('placeholder'=>'Description', 'class'=>'form-control', 'id'=>'description'))!!}
                            </div>  
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" id="file_id" name="id" value="">
                    <input type="hidden" id="folder_id" name="folder_id" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.cancel')}}</button>
                    {!!Form::button(pick_trans('buttons.update'), array('type'=>'submit', 'class'=>"btn btn-info"))!!}
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade custom-width" id="modal-delete-file">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{pick_trans('files.role_delete_file')}}</h4>
            </div>
            
            <div class="modal-body">
                {{pick_trans('files.role_delete_file')}}
                <span id="modal-file-name"></span>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.cancel')}}</button>
                <button type="button" class="btn btn-info delete-button">{{pick_trans('buttons.delete')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-width" id="modal-delete-folder">
    <div class="modal-dialog" style="width: 650px;">
        {!!Form::open(array('url'=>$objectUrl.'/deletefolder'))!!}
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{pick_trans('files.role_delete_folder')}}</h4>
            </div>
            
            <div class="modal-body">
                {{pick_trans('files.role_delete_folder')}}
                <span id="modal-folder-name"></span>
                <input type="hidden" name="delete_folder_id" id="delete_folder_id" value="">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{pick_trans('buttons.cancel')}}</button>
                {!!Form::button(pick_trans('buttons.delete'), array('type'=>'submit', 'class'=>"btn btn-info delete-button"))!!}
            </div>

        </div>
        {!!Form::close()!!}
    </div>
</div>