<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker;

use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\BlockTemplate;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TwitterBootstrapV3\CommonTemplate;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TwitterBootstrapV3\FilterTemplate;
use Config, Session;

class TwitterBootstrapV3 extends FormakerAbstract implements FormakerInterface {

    public function __construct($end)
    {
        $this->config = Config::get('formaker.'.$end.'.TwitterBootstrapV3');
    }

    protected function field()
    {
        $namespace = Config::get('formaker.loadFormsNamespace');

        $data = [
            'name'   => $this->name,
            'value'  => $this->value,
            'class'  => $this->inputClass(),
            'others' => [
                'type'     => $this->type,
                'config'   => $this->config,
                'setting'  => $this->setting,
                'option'   => $this->option,
                'template' => $this->template,
            ],
        ];

        foreach ($namespace as $name)
        {
            $typeName  = ucfirst($this->type).'Form';
            $className = $name.$typeName;

            if (class_exists($className))
            {
                return (new $className())->make(array_merge($data, $this->args));
            }
        }

        throw new \InvalidArgumentException("It doesn't have any '{$typeName}' class exists");
    }

    /**
     * To return the class of input
     * @return string
     */
    public function inputClass()
    {
        // return the class from config setting
        return $this->config['input-class'];
    }

    /**
     * Make the form field
     * @param string $name
     * @param array $args
     */
    public function fetch()
    {
        switch ($this->template)
        {
            case 'filter':
                $template = new FilterTemplate();
                break;

            default:
                $template = new CommonTemplate();
                break;
        }

        $data = [
            'name'    => $this->name,
            'type'    => $this->type,
            'help'    => $this->getFormText('help'),
            'field'   => $this->field(),
            'setting' => $this->setting,
            'config'  => $this->config,
        ];

        return $template->make($data);
    }

}
