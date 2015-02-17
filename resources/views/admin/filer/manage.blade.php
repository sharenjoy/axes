<div class="row">
    <div class="col-md-12">
        <div class="file-manage">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @if(Session::get('onAction') != 'filealbum')
                        <th width="25%"><i class="fa fa-folder"></i> {{pick_trans('files.folders')}}</th>
                        @endif
                        <th><i class="fa fa-file-text"></i> {{pick_trans('files.files_title')}}&nbsp;&nbsp;<span id="file-point"><b></b></span></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        @if(Session::get('onAction') != 'filealbum')
                        <th width="25%"><i class="fa fa-folder"></i> {{pick_trans('files.folders')}}</th>
                        @endif
                        <th><i class="fa fa-file-text"></i> {{pick_trans('files.files_title')}}</th>
                    </tr>
                </tfoot>
                
                <tbody>
                    
                    <tr>
                        @if(Session::get('onAction') != 'filealbum')
                        <td>
                            <div id="list-1" class="nested-list dd with-margins">
                                <ul class="dd-list folders-folder">
                                    {!!$folderTree!!}
                                </ul>
                            </div>
                        </td>
                        @endif
                        <td>
                            <div id="sortable" class="file-context">
                                <ul class="folders-center">
                                    
                                    @if(count($fileResult['data']['folder']))
                                        @foreach($fileResult['data']['folder'] as $key => $folder)
                                            <li original-title="" class="folder" data-id="{{$folder['id']}}" data-name="{{$folder['name']}}"><span class="name-text">{{$folder['name'].'.'.$file['extension']}}</span></li>
                                        @endforeach
                                    @endif
                                    
                                    @if(count($fileResult['data']['file']))
                                        @foreach($fileResult['data']['file'] as $key => $file)
                                            <li original-title="" class="file type-{{$file['type']}}" data-id="{{$file['id']}}" data-name="{{$file['filename']}}" data-extension="{{$file['extension']}}" data-type="{{$file['type']}}">
                                                @if($file['type'] == 'i')
                                                <img src="{{asset('uploads/thumbs/'.$file['filename'].'.'.$file['extension'])}}" alt="{{$file['alt_attribute']}}">
                                                @endif
                                                <span class="name-text">{{$file['name'].'.'.$file['extension']}}</span>
                                            </li>
                                        @endforeach
                                    @endif

                                </ul>

                                <form name="filesortform">
                                    @if(count($fileResult['data']['file']))
                                        @foreach($fileResult['data']['file'] as $key => $file)
                                            <input type="hidden" value="{{$file['sort']}}" />
                                        @endforeach
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>