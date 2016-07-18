<?php namespace Sharenjoy\Cmsharenjoy\Modules\Tag;

use Illuminate\Support\Str;
use Sharenjoy\Cmsharenjoy\Modules\Tag\TagUtil;
use Sharenjoy\Cmsharenjoy\Modules\Tag\Tag;
use Sharenjoy\Cmsharenjoy\Utilities\CmsharenjoyString;

trait TaggableTrait {

	/**
	 * Return collection of tags related to the taggable model
	 * 
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function tags()
	{
		return $this->morphToMany('Sharenjoy\Cmsharenjoy\Modules\Tag\Tag', 'taggable');
	}

	/**
	 * To register a model event
	 */
	public function eventTaggable($key, $model)
    {
        $model->tag(self::$inputData['tag']);
    }

    /**
	 * To register a model event to remove all tags
	 */
	public function eventUnTaggable($key, $model)
    {
        $model->untag();
    }
	
	/**
	 * Perform the action of tagging the model with the given string
	 * 
	 * @param $tagName string or array
	 */
	public function tag($tagNames)
	{
		$tagNames = TagUtil::makeTagArray($tagNames);
		$currentTagNames = $this->tagNames();

		foreach ($tagNames as $key => $value) $tagNames[$key] = $this->format($value);

		$deletions = array_diff($currentTagNames, $tagNames);
		$additions = array_diff($tagNames, $currentTagNames);
		
		foreach($additions as $tagName)
		{
			$this->addTag($tagName);
		}
		foreach($deletions as $tagName)
		{
			$this->removeTag($tagName);
		}
	}

	/**
	 * Remove the tag from this model
	 * 
	 * @param $tagName string or array (or null to remove all tags)
	 */
	public function untag($tagNames = null)
	{
		if (is_null($tagNames))
		{
			$currentTagNames = $this->tagNames();
			foreach($currentTagNames as $tagName)
			{
				$this->removeTag($tagName);
			}
		}
		else
		{
			$tagNames = TagUtil::makeTagArray($tagNames);
			
			foreach($tagNames as $tagName)
			{
				$this->removeTag($this->format($tagName));
			}
		}
	}

	/**
	 * Add the tag from this model
	 * @param string|array $tagName
	 */
	public function intag($tagNames)
	{
		$tagNames = TagUtil::makeTagArray($tagNames);
		
		foreach($tagNames as $tagName)
		{
			$this->addTag($this->format($tagName));
		}
	}
	
	/**
	 * Return array of the tag names related to the current model
	 * @return array
	 */
	public function tagNames()
	{
		return $this->tags()->get()->lists('tag');
	}

	/**
	 * To format a string
	 * @param  string $tagName
	 * @return String
	 */
	protected function format($tagName)
	{
		return Str::title(CmsharenjoyString::slug(trim($tagName)));
	}
	
	/**
	 * Adds a single tag
	 * 
	 * @param $tagName string
	 */
	private function addTag($tagName)
	{
		if (is_null($tagName) || $tagName == '') return;

		// return Builder
        $tag = Tag::where('tag', '=', $tagName)->first();
		
		if (is_object($tag))
		{
			// To increment count number to exists tag
			TagUtil::incrementCount($tagName, 1, $tag);

			// return collection object
			$tagPivot = $this->tags()->wherePivot('tag_id', '=', $tag->id)->get();
			
	        if ($tagPivot->count() === 0)
	        {
				// To attach a related item to taggable
	        	$this->tags()->attach($tag->id);
	        }
		}
		else
		{
			$tag = new Tag(['tag' => $tagName]);
			
			$this->tags()->save($tag);	
		}
	}
	
	/**
	 * Removes a single tag
	 * 
	 * @param $tagName string
	 */
	private function removeTag($tagName)
	{
		if (is_null($tagName) || $tagName == '') return;

        $tag = Tag::where('tag', '=', $tagName)->first();

		if (is_object($tag))
		{
			if ($tag->count > 0) TagUtil::decrementCount($tagName, 1, $tag);

			// return collection object
			$tagPivot = $this->tags()->wherePivot('tag_id', '=', $tag->id)->get();
			
	        if ($tagPivot->count()) $this->tags()->detach($tag->id);
		}
	}

	/**
	 * Filter model to subset with the given tags
	 * 
	 * @param $tagNames array|string
	 */
	public function scopeWithAnyTag($query, $tagNames)
	{
		$tagNames = TagUtil::makeTagArray($tagNames);

		foreach($tagNames as $key => $tagName)
			$tagNames[$key] = $this->format($tagName);
		
		return $query->whereHas('tags', function($q) use($tagNames)
		{
			$q->whereIn('tag', $tagNames);
		});
	}

	/**
	 * Filter model to subset with the given tags
	 * 
	 * @param $tagNames array|string
	 */
	public function scopeWithAllTags($query, $tagNames)
	{
		$tagNames = TagUtil::makeTagArray($tagNames);
		
		foreach($tagNames as $tagName)
		{
			$tagName = $this->format($tagName);

			$query->whereHas('tags', function($q) use($tagName)
			{
				$q->where('tag', '=', $tagName);
			});
		}
		
		return $query;
	}

	public function grabTagLists()
	{
		return $this->tags()->getRelated()->get()->lists('tag', 'id');
	}

}
