<?php namespace Sharenjoy\Cmsharenjoy\Core\Traits;

use ReflectionClass;

trait CommonModelTrait {

    protected static $inputData = [];

    protected static $reflection = null;

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {$model->eventProcess('creating', $model);});
        static::created(function($model)  {$model->eventProcess('created', $model);});
        static::updating(function($model) {$model->eventProcess('updating', $model);});
        static::updated(function($model)  {$model->eventProcess('updated', $model);});
        static::saving(function($model)   {$model->eventProcess('saving', $model);});
        static::saved(function($model)    {$model->eventProcess('saved', $model);});
        static::deleting(function($model) {$model->eventProcess('deleting', $model);});
        static::deleted(function($model)  {$model->eventProcess('deleted', $model);});
    }

    /**
     * To process the input data in advance
     * @param array $input
     */
    public function setInput(array $input)
    {
        $input = $this->parseInputValue($input);

        if (session()->has('cmsharenjoy.language')) {
            $input['language'] = session('cmsharenjoy.language');
        }

        self::$inputData = $input;
    }

    public function getInput()
    {
        return self::$inputData;
    }

    protected function parseInputValue($input)
    {
        /**
         * If the field of input is an array
         * To convert the array to string
         */
        if (count($input))
        {
            foreach ($input as $key => $value)
            {
                if (is_array($input[$key]))
                {
                    if (strstr($key, 'serialize') !== false)
                    {
                        $input[$key] = serialize($value);
                    }
                    else
                    {
                        foreach ($value as $k => $item)
                        {
                            if ( ! $item) unset($value[$k]);
                        }

                        $input[$key] = join(',', $value);
                    }
                }
            }
        }

        /**
         * If the value that has been sant is null
         * To set the value to null
         */
        $configProperty = session('onAction').'FormConfig';
        $formConfig = isset($this->$configProperty) ? $this->$configProperty : $this->formConfig;

        if (count($formConfig))
        {
            $check_type = ['checkbox', 'selectMultiList', 'selectMulti'];

            foreach ($formConfig as $key => $value)
            {
                if ( ! isset($input[$key]) && (isset($value['type']) && in_array($value['type'], $check_type)))
                {
                    $input[$key] = '';
                }
            }
        }
        
        return $input;
    }

    /**
     * Set what kind of data that we went to get
     * @param  Model $model
     * @return Model
     */
    public function listQuery()
    {
        return $this->orderBy('sort', 'desc');
    }

    /**
     * To process the event of model
     * @param  string $event
     * @param  object $model
     * @return void
     */
    public function eventProcess($event, $model = null)
    {
        if (isset($this->eventItem[$event]) && count($this->eventItem[$event]))
        {
            foreach ($this->eventItem[$event] as $item)
            {
                if (strpos($item, '|') !== false)
                {
                    $args   = explode('|', $item);
                    $method = 'event'.studly_case($args[0]);
                    $this->{$method}($args, $model);
                }
                else
                {
                    $method = 'event'.studly_case($item);
                    $this->{$method}($item, $model);
                }
            }
        }
    }

    /**
     * What this method doing is can dynamic push
     * some form data config to model's form config
     * @param  array  $data
     * @param  string $form
     * @return void
     */
    public function pushForm(array $data, $form = 'formConfig')
    {
        if (isset($this->$form))
        {
            return $this->$form = array_merge($this->$form, $data);
        }

        throw new \InvalidArgumentException("The model doesn't exist the {$form} property.");
    }

    public function processForm($formConfig, $input = array())
    {
        if (count($formConfig))
        {
            foreach ($formConfig as $name => $config)
            {
                // To get the options of select element from the Model
                if (isset($config['method']))
                {
                    $method = camel_case($config['method']);
                    $formConfig[$name] = array_merge($formConfig[$name], $this->$method());
                }

                // To get the options of select element from the Model
                if (isset($config['relation']))
                {
                    $id = isset($input['id']) ? $input['id'] : '';
                    $relation = camel_case($config['relation']);
                    $formConfig[$name] = array_merge($formConfig[$name], $this->$relation($id));
                }

                // If use key that the name is input of value otherwise use the $key
                if (isset($config['input']) && isset($input[$config['input']]))
                {
                    $formConfig[$name]['value'] = $input[$config['input']];
                }
                elseif (isset($input[$name]))
                {
                    $formConfig[$name]['value'] = $input[$name];
                }
            }
        }
        
        return $formConfig;
    }

    public function getReflection()
    {
        if (is_null(static::$reflection))
        {
            static::$reflection = new ReflectionClass($this);
        }

        return static::$reflection;
    }

}