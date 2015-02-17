<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta http-equiv="expires" content="-1">
    <meta name="robots" content="none">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    
    <title>{{pick_trans('menu.file')}}</title>
    
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/font-icons/entypo/css/entypo.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/font-icons/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-core.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-theme.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/neon-forms.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/skins/white.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/sharenjoy/custom.css')}}">

    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/css/fileupload/files.css')}}">
    <link rel="stylesheet" href="{{asset('packages/sharenjoy/cmsharenjoy/js/dropzone/dropzone.css')}}">

    <!--[if lt IE 9]><script src="{{asset('packages/sharenjoy/cmsharenjoy/js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
</head>
<body class="page-body skin-white" id="filemanager">

    <div class="page-container">
        <div class="main-content">
        
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <button type="button" id="new-folder" class="btn btn-blue btn-lg" onclick="jQuery('#modal-new-folder').modal('show', {backdrop: 'static'});">{{pick_trans('files.new_folder')}}</button>
                            <button type="button" id="new-file" class="btn btn-blue btn-lg" onclick="jQuery('#modal-create-file').modal('show', {backdrop: 'static'});">{{pick_trans('files.role_upload')}}</button>
                            <button type="button" id="file-pick" class="btn btn-orange btn-lg" style="display:none">{{pick_trans('files.pick_file')}}</button>
                            <button type="button" id="file-detail" class="btn btn-success btn-lg" style="display:none">{{pick_trans('files.role_edit_file')}}</button>
                            <button type="button" id="delete-file" class="btn btn-danger btn-lg" style="display:none">{{pick_trans('files.role_delete_file')}}</button>
                        </div>
                    </div>
                    
                    @include('admin.partials.messaging')
                    
                    @include('admin.filer.manage')

                </div>
            </div>

        </div>
    </div>

    @include('admin.filer.modal')

    <script type="text/javascript">
        var sharenjoy          = {};
        sharenjoy.APPURL       = "{{Config::get('app.url')}}/{{$accessUrl}}/{{Session::get('onController')}}";
        sharenjoy.OBJURL       = "{{$objectUrl}}";
        sharenjoy.SITEURL      = "{{Config::get('app.url')}}";
        sharenjoy.BASEURI      = "{{base_path()}}";
        sharenjoy.PUBLICURI    = "{{public_path()}}";
        sharenjoy.csrf_token   = "{{csrf_token()}}";
        sharenjoy.file = {};
        sharenjoy.file.parent_id = "{{$parentId}}";
        sharenjoy.file.upload_max_filesize = {{$uploadMaxFilesize}};

        var opts = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-bottom-left",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>

    <!-- Javascript Output Starts -->
    @include('partials.javascript-print')
    <!-- Javascript Output Ends -->

    <!-- Bottom Scripts -->
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/bootstrap.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/toastr.js')}}"></script>
    <script src="{{asset('packages/sharenjoy/cmsharenjoy/js/dropzone/dropzone.min.js')}}"></script>

    <script>
        $(function() {

            var $new_folder_button  = $('#new-folder');
            var $new_file_button    = $('#new-file');
            var $file_pick_button   = $('#file-pick');
            var $delete_file_button = $('#delete-file');
            var $file_detail_button = $('#file-detail');
            var $modal_delete_file  = $('#modal-delete-file');
            var $modal_file_detail  = $('#modal-file-detail');
            var unselected_blank    = ['UL', 'TD', 'TH', 'DIV'];
            var append_files = [];
            var append_form  = [];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': sharenjoy.csrf_token
                }
            });

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

                // show file detail button
                if($file_pick_button.css('display') == 'none'){
                    $file_pick_button.fadeIn();
                }
            }

            var hide_something = function(){
                $('#file-point b').text('');
                $delete_file_button.hide();
                $file_detail_button.hide();
                $file_pick_button.hide();
                $('.folders-center li').removeClass('selected');
            }

            $('.folders-center').on('click', 'li', function (e) {
                e.preventDefault();

                // console.log(e.target.tagName);
                $('.folders-center li').removeClass('selected');
                $(this).toggleClass('selected');

                // show file name
                $('#file-point b').html($(this).find('span').html());

                show_something();
                
            });

            $('.file-manage').on('click', function(e){
                // console.log(e.target.tagName);
                if (jQuery.inArray(e.target.tagName, unselected_blank) !== -1){
                    $(this).find('li').removeClass('selected');
                    hide_something();
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

            $delete_file_button.on('click', function(){
                $modal_delete_file.find('#modal-file-name').text($('.folders-center li.selected span').html());
                $modal_delete_file.modal('show', {backdrop: 'static'});
            });

            $file_pick_button.on('click', function(){
                var file;

                var field_name = $(parent.document).contents().find('#pick_field_name').val();
                var $parent    = $(parent.document).contents().find('#'+field_name);
                var $from_file = $('.folders-center li.selected');
                var type       = $from_file.attr('data-type');
                var ext        = $from_file.attr('data-extension');
                var name       = $from_file.attr('data-name') + '.' + ext;

                if (type == 'i') {
                    file = sharenjoy.SITEURL + '/uploads/' + name;
                }else{
                    file = sharenjoy.SITEURL + '/packages/sharenjoy/cmsharenjoy/css/fileupload/img/' + type + '.png';
                }

                parent.modal_hide('#modal-filemanager');
                $parent.find('img').attr('src', file);
                $parent.find('input').attr('value', name);
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

            // sortable
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

</body>
</html>
