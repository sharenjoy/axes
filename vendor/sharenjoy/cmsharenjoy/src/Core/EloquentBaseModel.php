<?php namespace Sharenjoy\Cmsharenjoy\Core;

use Sharenjoy\Cmsharenjoy\Core\Traits\CommonModelTrait;
use Sharenjoy\Cmsharenjoy\Core\Traits\EventModelTrait;
use Sharenjoy\Cmsharenjoy\Core\Traits\ScopeModelTrait;
use Eloquent;

abstract class EloquentBaseModel extends Eloquent {

    use CommonModelTrait;
    use EventModelTrait;
    use ScopeModelTrait;

}