<?php namespace Sharenjoy\Cmsharenjoy\Modules\Tag;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class TagRepository extends EloquentBaseRepository implements TagInterface {

    public function __construct(Tag $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
    }

    /**
     * Sync tags
     * @param mixed  $tags can be array or string
     * @return array The id of array
     */
    public function syncTags($tags)
    {
        // Get the data of tags which is trimed and verify
        $tags = $this->getTagsArray($tags);

        // Create or add tags and return an Collection object
        $tagIds = $this->findOrCreate($tags);

        return $tagIds;
    }

    /**
     * Find existing tags or create if they don't exist
     * @param  array $tags  Array of strings, each representing a tag
     * @return array        Array or Arrayable collection of Tag objects
     */
    public function findOrCreate(array $tags)
    {
        $foundTags = $this->model->whereIn('tag', $tags)->get();

        $returnTags = array();

        if ($foundTags)
        {
            foreach ($foundTags as $tag)
            {
                $pos = array_search($tag->tag, $tags);

                // Add returned tags to array
                if($pos !== false)
                {
                    $returnTags[] = $tag->id;
                    unset($tags[$pos]);
                }
            }
        }

        // Add remainings tags as new
        if ($tags)
        {
            foreach ($tags as $tag)
            {
                $returnTags[] = $this->create(array('tag' => $tag));
            }
        }
        
        return $returnTags;
    }

    /**
     * Return a comma separated list of tags for use in the views, 
     * can be called like $item->tags_csv
     * @return string
     */
    public function getTagsCsv($data)
    {
        $tags = array();
        foreach($data as $tag)
        {
            $tags[] = $tag->tag;
        }

        return implode(',', $tags);
    }

    /**
     * Convert string to an array and trim and verify
     * @param  mixed
     * @return array
     */
    public function getTagsArray($tags)
    {
        $ary = array();

        if(is_string($tags))
        {
            $tags = explode(',', $tags);

            foreach($tags as $tag)
            {
                $ary[] = trim($tag);
            }
        }
        elseif(is_array($tags))
        {
            foreach($tags as $tag)
            {
                $ary[] = trim($tag);
            }
        }

        return array_unique($ary);
    }

}