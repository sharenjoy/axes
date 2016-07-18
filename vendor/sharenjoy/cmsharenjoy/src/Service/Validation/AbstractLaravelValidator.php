<?php namespace Sharenjoy\Cmsharenjoy\Service\Validation;

use Illuminate\Validation\Factory;
use App, Message, StdClass, Lang, Session;

abstract class AbstractLaravelValidator implements ValidableInterface {

    /**
     * Validator
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data key => value array
     * @var Array
     */
    protected $data = [];

    /**
     * Validation errors
     * @var Array
     */
    protected $errors = [];

    /**
     * Validation rules
     * @var Array
     */
    protected $rules = [];

    /**
     * This is the unique id that want to update row's id
     * @var string
     */
    protected $uniqueId = null;

    /**
     * Unique fields
     * @var Array
     */
    protected $unique = [];

    public function __construct(Factory $validator = null)
    {
        if ($validator == null)
        {
            $this->validator = App::make('validator');
        }
        else
        {
            $this->validator = $validator;
        }
    }

    /**
     * To overwrite normal rules
     * @param mixed $rule The new rule
     */
    public function setRule($rule)
    {
        if (is_string($rule))
        {
            if (isset($this->$rule))
                $this->rules = $this->$rule;
            else
                throw new \Sharenjoy\Cmsharenjoy\Exception\ValidatorRulesNotFoundException;
        }
        elseif (is_array($rule))
        {
            $this->rules = $rule;
        }

        return $this;
    }

    /**
     * To set the unique id that want to update row
     * @param string $id
     */
    public function setUniqueId($id)
    {
        if (is_string($id))
        {
            $this->uniqueId = $id;
        }
        return $this;
    }

    /**
     * To overwrite normal unique
     * @param string $action The new rule
     */
    public function setUniqueFields($unique)
    {
        if (count($unique))
        {
            $this->unique = $unique;
        }
        else
        {
            throw new \Sharenjoy\Cmsharenjoy\Exception\ValidatorRulesNotFoundException;
        }

        return $this;
    }

    /**
     * To set some column don't need to valid
     * @param array $keyAry
     * @param string $id
     */
    public function setUnique($id = null, $unique = null)
    {
        $id     = $id ?: $this->uniqueId;
        $unique = $unique ?: $this->unique;

        if (count($unique) && $id != null)
        {
            foreach ($unique as $field)
            {
                if (isset($this->rules[$field]))
                {
                    $rules = $this->rules;
                    $this->rules[$field] = $rules[$field].','.$id;
                }
            }
        }

        return $this;
    }

    /**
     * Return the custom message form lang file
     * @return array
     */
    protected function messages()
    {
        $messages = [];
        $pkg = Session::get('onPackage');

        if (Lang::has($pkg.'::'.$pkg.'.form.validation'))
        {
            $messages = array_merge($messages, Lang::get($pkg.'::'.$pkg.'.form.validation'));
        }

        if (Lang::has($pkg.'.form.validation'))
        {
            $messages = array_merge($messages, Lang::get($pkg.'.form.validation'));
        }

        return $messages;
    }

    /**
     * Custom message attribute
     * @return array
     */
    protected function attributes()
    {
        $attributes = [];
        $controller = Session::get('onController');

        foreach ($this->rules as $key => $value)
        {
            if (pick_trans('form.'.$controller.'.'.$key))
            {
                $attributes[$key] = pick_trans('form.'.$controller.'.'.$key);
            }
            else
            {
                $attributes[$key] = pick_trans('form.'.$key);
            }
        }

        return $attributes;
    }

    /**
     * Set data to validate
     * @return \Sharenjoy\Cmsharenjoy\Service\Validation\AbstractLaravelValidator
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Validation passes or fails
     * @return Boolean
     */
    public function passes()
    {
        $validator = $this->validator->make(
            $this->data,
            $this->rules,
            $this->messages(),
            $this->attributes()
        );

        if ($validator->fails())
        {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Return errors
     * @return MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Merge message to flashMessageBag
     * @return void
     */
    public function getErrorsToFlashMessageBag()
    {
        $errors = $this->errors()->toArray();
        
        if (count($errors))
        {
            foreach ($errors as $message)
            {
                Message::error($message);
            }
        }
    }

    /**
     * Test if form validator passes
     * @param  array The input needs to valid
     * @param  array The type of message, it can be 'messageBeg'
     * @return boolean|Message
     */
    public function valid(array $input, $errorType)
    {
        $result = $this->with($input)->passes();

        if ( ! $result)
        {
            switch ($errorType)
            {
                case 'flash':
                    $this->getErrorsToFlashMessageBag();
                    break;

                case 'json':
                    return Message::json(
                        400,
                        pick_trans('check_some_wrong'),
                        $this->errors()->toArray()
                    );
                    break;
                
                default:
                    Session::flash('sharenjoy.validation.errors', $this->errors());
                    Message::error(pick_trans('check_some_wrong'));
                    break;
            }
        }
        
        return $result;
    }

}