<?php
    
return [
    
    // General
    'files_title'              => '文件',
    'fetching'                 => '收集數據中...',
    'fetch_completed'          => '結束',
    'save_failed'              => '不能保存修改',
    'item_created'             => '檔案創建 "%s" 成功',
    'item_updated'             => '檔案更新成功',
    'item_deleted'             => '檔案刪除 "%s" 成功',
    'item_not_deleted'         => '"%s" 不能被刪除',
    'item_not_found'           => '對不起. 未能發現 "%s"',
    'sort_saved'               => '新排序保存成功',
    'folder_created'           => '文件夾建立成功',
    'folder_deleted'           => '文件夾 ":name" 刪除成功',
    'no_permissions'           => '您未有足夠權限',
    
    // Labels
    'activity'                 => '活動',
    'places'                   => '位置',
    'back'                     => '後退',
    'forward'                  => '前進',
    'start'                    => '開始上傳',
    'details'                  => '細節',
    'name'                     => '名稱',
    'slug'                     => '簡寫',
    'path'                     => '路徑',
    'added'                    => '創建日期',
    'width'                    => '寬度',
    'height'                   => '高度',
    'ratio'                    => '比例',
    'full_size'                => '原始大小',
    'filename'                 => '文件名',
    'filesize'                 => '文件大小',
    'download_count'           => '下載次數',
    'download'                 => '下載',
    'location'                 => '位置',
    'description'              => '描述',
    'container'                => '容器',
    'bucket'                   => '批量',
    'check_container'          => '檢查正確性',
    'search_message'           => '輸入並執行',
    'search'                   => '搜索',
    'synchronize'              => '同步',
    'uploader'                 => '拖放文件至此 或 點擊選擇文件',
    
    // Context Menu
    'refresh'                  => '重新載入',
    'open'                     => '打開',
    'new_folder'               => '新的文件夾',
    'upload'                   => '上傳',
    'rename'                   => '重命名',
    'delete'                   => '刪除',
    'edit'                     => '編輯',
    'details'                  => '細節',
    'pick_file'                => '指定此檔案',
    
    // Folders
    
    'no_folders'               => '文件和文件夾進行管理，就像他們將在您的桌面上。右鍵單擊在下面這個消息，以創建您的第一個文件夾的面積。然後右擊該文件夾重命名，刪除，上傳文件，或更改，如連接到雲位置的詳細信息。',
    'no_folders_places'        => '你創建的文件夾，將顯示在一個可以展開和折疊樹。 「鄰居」，點擊查看根文件夾。',
    'no_folders_wysiwyg'       => '沒有任何文件夾',
    'new_folder_name'          => '未命名',
    'folder'                   => '文件夾',
    'folders'                  => '文件夾',
    'select_folder'            => '選擇一個目錄',
    'subfolders'               => '子目錄',
    'root'                     => '根目錄',
    'no_subfolders'            => '無子目錄',
    'folder_not_empty'         => '如果您要刪除此文件夾 ":name" 您必須先刪除此文件夾內的所有檔案',
    'mkdir_error'              => '無法創建 %s. 您必須手動操作。',
    'chmod_error'              => '上傳目錄不可寫。請確認權限是 0777',
    'location_saved'           => '目錄位置保存成功',
    'container_exists'         => '"%s" 已經存在。存儲鏈接到該文件夾​​的內容。',
    'container_not_exists'     => '您的帳號沒有 "%s". 請保存，我們將嘗試創建。 ',
    'error_container'          => '未知原因而不能保存 "%s" ',
    'container_created'        => '"%s" 被保存並連接到本目錄',
    'unwritable'               => '"%s" 是只讀屬性，請修改權限為 0777',
    'specify_valid_folder'     => '您必須上傳文件到一個有效的目標目錄',
    'enable_cdn'               => '在開始同步前，請為 "%s" 在Rackspace的控制面板上激活CDN。',
    'synchronization_started'  => '開始同步',
    'synchronization_complete' => '與同步 "%s" 成功',
    'untitled_folder'          => '未命名目錄',
    'folder_name'              => '文件夾名稱',
    'folder_placeholder'       => '請輸入文件夾的名稱',
    
    // Files
    'no_files'                 => '無文件',
    'file_uploaded'            => '"%s" 被上傳成功',
    'unsuccessful_fetch'       => '無法獲取 "%s". 請確認此文件為公共屬性。',
    'invalid_container'        => '"%s" 為非法容器.',
    'no_records_found'         => '沒有記錄',
    'invalid_extension'        => '文件 "%s" 的後綴被限制',
    'upload_error'             => '文件上傳失敗',
    'description_saved'        => '新的文件描述被保存成功',
    'file_moved'               => '"%s" 被成功移動',
    'exceeds_server_setting'   => '服務器不能負擔此大型文件',
    'exceeds_allowed'          => '文件大小超過限制',
    'file_type_not_allowed'    => '不允許上傳此類型文件',
    'type_a'                   => '聲音',
    'type_v'                   => '影像',
    'type_d'                   => '文件',
    'type_i'                   => '圖片',
    'type_o'                   => '其他',
    
    // Files Permissions
    'role_wysiwyg'             => '從WYSIWYG中管理文件',
    'role_upload'              => '上傳文件',
    'role_download_file'       => '下載文件',
    'role_edit_file'           => '編輯文件',
    'role_delete_file'         => '刪除文件',
    
    'role_create_folder'       => '創建文件夾',
    'role_set_location'        => '設置雲端的提供商',
    'role_synchronize'         => '與雲端同步',
    'role_edit_folder'         => '編輯文件夾',
    'role_delete_folder'       => '刪除文件夾',

    'help_body'                => "
    <h6>概觀</h6><hr>
    <p>文件模塊是一個很好的方式，為網站管理員在網站上使用的文件管理。
    頁，畫廊，博客文章中插入圖像或文件都存儲在這裡。
    對於頁面內容的圖像，你可以上傳他們直接從所見即所得的編輯器，你可以上傳他們在這裡，只需插入他們通過所見即所得。</p>
    <p>文件的界面很像一個本地文件系統，它使用右鍵顯示上下文菜單。在中間窗格中的一切都是可點擊的。</p>

    <h6>管理文件夾</h6>
    <p>在創建頂級文件夾或文件夾，你可以創建多個子文件夾，你需要，如博客/圖片/截圖/或網頁/音頻/。您使用的文件夾名稱，名稱不顯示在前端的下載鏈接。管理文件夾右擊它並選擇從菜單或文件夾，雙擊打開它的行動。你也可以點擊左欄中的文件夾，打開它們。
    </p>
    <p>如果啟用了雲提供商，您將可以設置文件夾的位置，右擊文件夾，然後選擇詳情。
    然後，您可以選擇一個位置（例如\"亞馬遜S3\"）把遠程桶或容器的名字。如果桶或容器
    不存在將創建當您單擊保存。請注意，你只能改變一個空文件夾的位置。</p>

    <h6>管理文件</h6>
    <p>管理文件，瀏覽到的文件夾，在左側立柱上的文件夾在中間窗格中點擊文件夾樹。
    一旦您正在查看的文件，通過右鍵點擊它們，你可以編輯他們。你還可以訂購他們拖入他們的位置。注意
    這如果你有相同的父文件夾的文件夾和文件夾將總是首先顯示文件。</p>

    <h6>上傳文件</h6>
    <p>上傳窗口，右鍵單擊所需的文件夾後會出現。
    您可以通過拖放上傳文件框，或在框中單擊並選擇您的標準文件對話框的文件添加文件。
    由持有控制/命令或Shift鍵的同時點擊，您可以選擇多個文件。選定的文件將顯示在屏幕底部的列表。
    然後，您可以刪除不必要的文件從列表或如果滿意單擊Upload開始上傳過程。</p>
    <p>如果你得到一個警告有關文件是規模過大，被告知，許多主機不允許超過2MB的文件上傳。
    許多現代相機生產5MB exess圖像，所以它運行到這個問題是很常見的。
    為了彌補這個限制，你可能問你的主機，改變上傳限制或上傳之前，你不妨調整您的圖像。
    大小有增加的優勢，更快的上傳時間。你可能會改變上傳限制
    CP>文件>設置也卻是次要的主機的限制。例如，如果主機允許一個50MB的上傳，你仍然可以限制大小
    通過設置最大的\"20\"CP（例如）「>」文件「>」設置「上傳。</p>

    <h6>同步文件</h6>
    <p>如果您正在存儲與雲服務提供商的文件，你可能想使用同步功能。這允許你\"刷新\"
    您的數據庫文件保持最新與遠程存儲位置。例如，如果您有其他服務
    轉儲文件到亞馬遜上的文件夾，你要顯示在您的每週博客文章，你可以簡單地去給你的文件夾
    鏈接到該桶，單擊同步。這將拉低所有可用的信息，從亞馬遜
    存儲在數據庫中，如果該文件通過文件接口上傳。文件現在可以被插入到頁面內容，
    您的博客後，或等，如果文件已被刪除，因為您上次同步現在，他們將被刪除從遠程桶
    數據庫。</p>

    <h6>搜索</h6>
    <p>你可以搜索所有文件和文件夾，在右列中鍵入搜索字詞，然後按下回車鍵。第一
    5文件夾的比賽，前5個文件的比賽將被退回。當您單擊一個項目上，將顯示其包含的文件夾
    您的搜索匹配的項目將突出顯示。項目使用的文件夾名，文件名，擴展搜索，
    位置，遠程容器的名稱。</p>",
    
];
