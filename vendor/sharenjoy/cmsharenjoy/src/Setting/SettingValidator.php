<?php namespace Sharenjoy\Cmsharenjoy\Setting;

use Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator;

class SettingValidator extends AbstractLaravelValidator {

    /**
     * Validation rules
     *
     * @var Array
     */
    public $rules = [
        'id'      => 'required|exists:settings',
        'value'   => 'required'
    ];

}