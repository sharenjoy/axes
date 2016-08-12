<?php namespace Sharenjoy\Cmsharenjoy\Service\Categorize\Categories;

use App\Modules\Category\ConfigTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseModel;
use Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\CategoryInterface;

class Category extends EloquentBaseModel implements CategoryInterface {

    use ConfigTrait;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'description'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Model event.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Delete hierarchies first.
        static::deleting(function($model)
        {
            $model->eventProcess('deleting', $model);

            // if delete the parent also delete the children
            $model->children()->delete();

            // use soft delete so do not want to detach
            // $model->children()->detach();
            // $model->parents()->detach();
        });

        static::restoring(function($model)
        {
            $model->eventProcess('restoring', $model);

            // if restore the parent also restore all of the children
            // $model->children()->restore();
        });
    }

    /**
     * Category parents.
     *
     * @return object
     */
    public function parents()
    {
        return $this->belongsToMany('\Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\Category', 'category_hierarchy', 'category_id', 'category_parent_id');
    }

    /**
     * Category children.
     *
     * @return object
     */
    public function children()
    {
        return $this->belongsToMany('\Sharenjoy\Cmsharenjoy\Service\Categorize\Categories\Category', 'category_hierarchy', 'category_parent_id', 'category_id');
    }

    /**
     * Category has many contents.
     *
     * @return object
     */
    public function relates()
    {
        return $this->hasMany('\Sharenjoy\Cmsharenjoy\Service\Categorize\CategoryRelates\Relate');
    }

    /**
     * Make new category as root.
     *
     * @return object
     */
    public function makeRoot()
    {
        $this->save();
        $this->parents()->sync(array(0));

        return $this;
    }

    /**
     * Make new category into some parent.
     *
     * @param  CategoryInterface $category
     * @return object
     */
    public function makeChildOf(CategoryInterface $category)
    {
        $this->save();
        $this->parents()->sync(array($category->getKey()));

        return $this;
    }

    /**
     * Get category with nested.
     *
     * @param  string $defination
     * @return object
     */
    public function getNested($defination)
    {
        $this->load(implode('.', array_fill(0, 20, $defination)));

        return $this;
    }

    /**
     * Get children.
     *
     * @return object
     */
    public function getChildren()
    {
        return $this->getNested('children');
    }

    /**
     * Get parents.
     *
     * @return object
     */
    public function getParents()
    {
        return $this->getNested('parents');
    }

    /**
     * Delete category with all children.
     *
     * @return object
     */
    public function deleteWithChildren()
    {
        $ids = array();

        $children = $this->getChildren()->toArray();

        array_walk_recursive($children, function($i, $k) use (&$ids) { if ($k == 'id') $ids[] = $i; });

        foreach ($ids as $id)
        {
            $this->destroy($id);
        }
    }

}