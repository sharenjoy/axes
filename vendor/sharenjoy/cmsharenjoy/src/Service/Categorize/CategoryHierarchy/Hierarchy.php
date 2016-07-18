<?php namespace Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryHierarchy;

use Illuminate\Database\Eloquent\Model;
use Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryHierarchy\HierarchyInterface;

class Hierarchy extends Model implements HierarchyInterface {

    /**
     * Model table.
     *
     * @var string
     */
    protected $table = 'category_hierarchy';

    /**
     * Guarded.
     *
     * @var array
     */
    protected $guarded = array();

}