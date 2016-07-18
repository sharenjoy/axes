<?php namespace Sharenjoy\Cmsharenjoy\Filer;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class FilerValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $newFolderRules = [
        'folder_name' => 'required|unique:file_folders,name'
    ];

    protected $fileUpdateRules = [
        'name' => 'required'
    ];

}