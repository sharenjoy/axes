<?php namespace Sharenjoy\Cmsharenjoy\Modules\Tag;

/**
 * Utility functions to help with various tagging functionality.
 * 
 * @author Rob Conner <rtconner@gmail.com>
 */
class TagUtil {
	
	/**
	 * Converts input into array
	 * 
	 * @param $tagName string or array
	 * @return array
	 */
	public static function makeTagArray($tagNames)
	{
		if(is_string($tagNames))
		{
			$tagNames = explode(',', $tagNames);
		}
		elseif( ! is_array($tagNames))
		{
			$tagNames = array(null);
		}
		
		$tagNames = array_map('trim', $tagNames);

		return $tagNames;
	}

	/**
	 * Private! Please do not call this function directly, just let the Tag library use it.
	 * Increment count of tag by one. This function will create tag record if it does not exist.
	 * 
	 * @param string $tagString
	 */
	public static function incrementCount($tagName, $count, $tag = null)
	{
		if($count <= 0) { return; }
		
		if ( ! $tag)
		{
			$tag = Tag::where('tag', '=', $tagName)->first();
		}

		$tag->count = $tag->count + $count;

		$tag->save();
	}
	
	/**
	 * Private! Please do not call this function directly, let the Tag library use it.
	 * Decrement count of tag by one. This function will create tag record if it does not exist.
	 *
	 * @param string $tagString
	 */
	public static function decrementCount($tagName, $count, $tag = null)
	{
		if($count <= 0) { return; }
			
		if( ! $tag)
		{
			$tag = Tag::where('tag', '=', $tagName)->first();
		}

		$tag->count = $tag->count - $count;

		if($tag->count < 0)
		{
			$tag->count = 0;
			\Log::warning("The \Sharenjoy\Cmsharenjoy\Modules\Tag count for `$tag->name` was a negative number. This probably means your data got corrupted. Please assess your code and report an issue if you find one.");
		}
		$tag->save();
	}
	
}