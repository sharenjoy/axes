@extends('admin.layouts.interface')

@section('title')
{{pick_trans('manage')}}{{pick_trans($onController)}}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h3>{{pick_trans("$onPackage.$onController")}}</h3>
                    </div>
                    <div class="panel-options">
                        <!-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> -->
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <!-- <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> -->
                    </div>
                </div>

                <div class="panel-body">
                    <button type="button" id="new-folder" class="btn btn-blue btn-lg" onclick="jQuery('#modal-new-folder').modal('show', {backdrop: 'static'});">{{pick_trans('files.new_folder')}}</button>
                    <button type="button" id="new-file" class="btn btn-blue btn-lg" onclick="jQuery('#modal-create-file').modal('show', {backdrop: 'static'});">{{pick_trans('files.role_upload')}}</button>
                    <button type="button" id="delete-folder" class="btn btn-danger btn-lg">{{pick_trans('files.role_delete_folder')}}</button>
                    <button type="button" id="file-detail" class="btn btn-success btn-lg" style="display:none">{{pick_trans('files.role_edit_file')}}</button>
                    <button type="button" id="delete-file" class="btn btn-danger btn-lg" style="display:none">{{pick_trans('files.role_delete_file')}}</button>
                </div>

            </div>
            
            @include('admin.partials.messaging')
            
            @include('admin.filer.manage')

        </div>
    </div>

@stop

@section('modal')
    @include('admin.filer.modal')
@stop

@section('main-scripts')
    @parent
    sharenjoy.file = {};
    sharenjoy.file.parent_id = "{{$parentId}}";
    sharenjoy.file.upload_max_filesize = {{$uploadMaxFilesize}};
@stop

@section('scripts')
    @parent
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/fileupload/files.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/js/dropzone/dropzone.css')}}">
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/dropzone/dropzone.min.js')}}"></script>

    <script>
        $(function() {

            var $new_folder_button  = $('#new-folder');
            var $new_file_button    = $('#new-file');
            var $delete_folder_button = $('#delete-folder');
            var $delete_file_button = $('#delete-file');
            var $file_detail_button = $('#file-detail');
            var $modal_delete_folder = $('#modal-delete-folder');
            var $modal_delete_file  = $('#modal-delete-file');
            var $modal_file_detail  = $('#modal-file-detail');
            var unselected_blank    = ['UL', 'TD', 'TH', 'DIV'];
            var append_files = [];
            var append_form  = [];

            $('.dd-list li[data-id="{{$parentId}}"]').find('.dd-handle').addClass('selected');
            $('.dd-list li[data-id="{{$parentId}}"] .dd-handle').find('i').attr('class', 'fa fa-folder-open');

            $('#modal-new-folder').on('shown.bs.modal', function (e) {
                $(this).find('input[type="text"]').val('');
            });

            $('#modal-create-file').on('hidden.bs.modal', function (e) {
                for (var i = 0; i < append_files.length; i++) {
                    $('.folders-center').append(append_files[i]);
                }
                append_files = [];

                for (var i = 0; i < append_form.length; i++) {
                    $('.file-context form').append(append_form[i]);
                }
                append_form = [];
            });

            $new_folder_button.click(function(){
                hide_something();
            });

            $new_file_button.click(function(){
                hide_something();
            });

            var show_something = function(){
                // The file was clicked and show delete button
                if($delete_file_button.css('display') == 'none'){
                    $delete_file_button.fadeIn();
                }

                // show file detail button
                if($file_detail_button.css('display') == 'none'){
                    $file_detail_button.fadeIn();
                }
            }

            var hide_something = function(){
                $('#file-point b').text('');
                $delete_file_button.hide();
                $file_detail_button.hide();
                $('.folders-center li').removeClass('selected');
            }

            var hide_some_button = function(){
                $delete_folder_button.hide();
                $new_folder_button.hide();
            }

            var show_some_button = function(){
                $delete_folder_button.fadeIn();
                $new_folder_button.fadeIn();
            }

            $('.folders-center').on('click', 'li', function (e) {
                e.preventDefault();

                // console.log(e.target.tagName);
                $('.folders-center li').removeClass('selected');
                $(this).toggleClass('selected');

                // show file name
                $('#file-point b').html($(this).find('span').html());

                show_something();

                hide_some_button();
            });

            $('.file-manage').on('click', function(e){
                // console.log(e.target.tagName);
                if (jQuery.inArray(e.target.tagName, unselected_blank) !== -1){
                    $(this).find('li').removeClass('selected');
                    hide_something();
                    show_some_button();
                }
            });

            $file_detail_button.on('click', function(){
                var send_data = {};
                var $selected = $('.folders-center li.selected');

                send_data = {
                    '_token': sharenjoy.csrf_token,
                    'file_id': $selected.attr('data-id'),
                    'file_name': $selected.attr('data-name')
                };
                
                $.post(sharenjoy.APPURL + "/find", send_data, function(data, status) {
                    if (data.status == true) {
                        $modal_file_detail.find('#file_id').val(data.data.id);
                        $modal_file_detail.find('#folder_id').val(data.data.folder_id);
                        $modal_file_detail.find('#name').val(data.data.name);
                        $modal_file_detail.find('#alt_attribute').val(data.data.alt_attribute);
                        $modal_file_detail.find('#description').val(data.data.description);

                        $modal_file_detail.modal('show', {backdrop: 'static'});
                    }
                });

            });

            $delete_folder_button.on('click', function(){
                $modal_delete_folder.find('#modal-folder-name').text($('.folders-folder div.selected span').html());
                $modal_delete_folder.find('#delete_folder_id').val($('.folders-folder div.selected').parent().parent().attr('data-id'));
                $modal_delete_folder.modal('show', {backdrop: 'static'});
            });

            $delete_file_button.on('click', function(){
                $modal_delete_file.find('#modal-file-name').text($('.folders-center li.selected span').html());
                $modal_delete_file.modal('show', {backdrop: 'static'});
            });

            $modal_delete_file.on('click', '.delete-button', function(){
                var send_data = {};
                var $selected = $('.folders-center li.selected');

                send_data = {
                    '_token': sharenjoy.csrf_token,
                    'file_id': $selected.attr('data-id'),
                    'file_name': $selected.attr('data-name')
                };

                $modal_delete_file.modal('hide');

                $.post(sharenjoy.APPURL + "/deletefile", send_data, function(result, status) {
                    if (result.status == true) {
                        $selected.remove();
                        hide_something();
                        toastr.success(result.message, "{{pick_trans('success')}}", opts);
                    }
                });
            });

            // myDropzone is the configuration for the element that has an id attribute
            // with the value my-dropzone (or myDropzone)
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#dropzone .dropzone", {
                maxFilesize: sharenjoy.file.upload_max_filesize,
                init: function () {
                    this.on("addedfile", function (file) {
                        // console.log(file);
                    });

                    this.on("success", function (file, response) {
                        if (response.status == true) {
                            append_files.push(response.data.append);
                            append_form.push(response.data.append_form);
                        }
                    });
                }
            });

            if($("#dropzone_example").length)
            {
                var dze_info = $("#dze_info"),
                    status = {uploaded: 0, errors: 0};
                
                var $f = $('<tr><td class="name"></td><td class="size"></td><td class="type"></td><td class="status"></td></tr>');

                myDropzone.on("success", function(file) {
                    
                    var _$f = $f.clone();
                    
                    dze_info.removeClass('hidden');
                    
                    _$f.addClass('success');
                    
                    _$f.find('.name').html(file.name);
                    _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                    _$f.find('.type').html(file.type);
                    _$f.find('.status').html('Uploaded <i class="entypo-check"></i>');
                    
                    dze_info.find('tbody').append( _$f );
                    
                    status.uploaded++;
                    
                    dze_info.find('tfoot td').html('<span class="label label-success">' + status.uploaded + ' uploaded</span> <span class="label label-danger">' + status.errors + ' not uploaded</span>');
                    
                })
                .on('error', function(file)
                {
                    var _$f = $f.clone();
                    
                    dze_info.removeClass('hidden');
                    
                    _$f.addClass('danger');
                    
                    _$f.find('.name').html(file.name);
                    _$f.find('.size').html(parseInt(file.size / 1024, 10) + ' KB');
                    _$f.find('.type').html(file.type);
                    _$f.find('.status').html('Uploaded <i class="entypo-cancel"></i>');
                    
                    dze_info.find('tbody').append( _$f );
                    
                    status.errors++;
                    
                    dze_info.find('tfoot td').html('<span class="label label-success">' + status.uploaded + ' uploaded</span> <span class="label label-danger">' + status.errors + ' not uploaded</span>');
                });
            }

            // Return a helper with preserved width of cells
            var fixHelper = function(e, ui) {
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                return ui;
            };
            $( "#sortable ul").sortable({
                helper: fixHelper,
                update:function(e, ui){

                    var id_value = [];
                    var sort_value = [];
                    var send_result = {};

                    $(this).find('li').each(function() {
                        id_value.push($(this).attr('data-id'));
                    });

                    $('.file-context form input').each(function() {
                        sort_value.push($(this).val());
                    });

                    send_result = {
                        '_token': sharenjoy.csrf_token,
                        'sort_value': sort_value,
                        'id_value': id_value
                    };

                    // console.log(send_result);

                    $.post(sharenjoy.APPURL + "/order", send_result)
                        .done(function(result) {
                            toastr.success(result.message, "{{pick_trans('success')}}", opts);
                        }).fail(function(result) {
                            toastr.error(result.message, "{{pick_trans('fail')}}", opts);
                        }
                    );
                }
            });
            $( "#sortable ul" ).disableSelection();

        });
    </script>
@stop
