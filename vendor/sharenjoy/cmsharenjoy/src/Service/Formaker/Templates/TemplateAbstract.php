<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Templates;

use Sharenjoy\Cmsharenjoy\Utilities\Parser;
use Session;

abstract class TemplateAbstract {

    protected $parser;

    public function __construct()
    {
        if ($this->parser == null)
        {
            $this->parser = new Parser();        
        }
    }

    /**
     * Clean up the field name for the label
     * @param string $name
     */
    protected function prettifyFieldName()
    {
        $name = $this->data['name'];
        $reference = 'form.'.Session::get('onController').'.'.$name;

        // If doesn't set the config of lang
        if (pick_trans($reference))
        {
            return pick_trans($reference);
        }

        if (pick_trans('form.'.$name))
        {
            return pick_trans('form.'.$name);
        }
        
        // convert foo_boo to fooBoo and then convert to Foo Boo
        return ucwords(preg_replace('/(?<=\w)(?=[A-Z])/', " $1", camel_case($name)));
    }

    protected function getSettingOrConfig($key)
    {
        if (isset($this->data['setting'][$key]) && ! is_null($this->data['setting'][$key]))
        {
            return $this->data['setting'][$key];
        }
        
        if (isset($this->data['config'][$key]) && ! is_null($this->data['config'][$key]))
        {
            return $this->data['config'][$key];
        }
        
        // throw new \InvalidArgumentException("It doesn't have any config suit for {$key}");
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    protected function attributes($attributes)
    {
        $html = array();

        // For numeric keys we will assume that the key and the value are the same
        // as this will convert HTML attributes such as "required" to a correct
        // form like required="required" instead of using incorrect numerics.
        foreach ((array) $attributes as $key => $value)
        {
            $element = $this->attributeElement($key, $value);

            if ( ! is_null($element)) $html[] = $element;
        }

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) $key = $value;

        if ( ! is_null($value)) return $key.'="'.e($value).'"';
    }

}