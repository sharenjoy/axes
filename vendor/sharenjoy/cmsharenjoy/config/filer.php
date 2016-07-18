<?php

return [

    'driver'           => 'file',
    
    'path'             => '/uploads',
    'thumbPath'        => '/uploads/thumbs',
    'cache_path'       => '/cloud_cache',

    'encrypt_filename' => true,

    'allowed_file_ext' => [
        'a'	=> ['mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'],
        'v'	=> ['mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie'],
        'd'	=> ['pdf', 'xls', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'xml', 'xsl', 'doc', 'docx', 'xlsx', 'word', 'xl', 'csv', 'pages', 'numbers'],
        'i'	=> ['bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'],
        'o'	=> ['psd', 'gtar', 'swf', 'tar', 'tgz', 'xhtml', 'zip', 'rar', 'css', 'html', 'htm', 'shtml', 'svg'],
    ],

];
