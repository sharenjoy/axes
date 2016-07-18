<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister\Templates;

use Sharenjoy\Cmsharenjoy\Utilities\Parser;
use Config, Session;

abstract class TemplateAbstract {

    protected $parser;

    protected $listsNamespace;

    protected $functionsNamespace;

    public function __construct()
    {
        if ($this->parser == null)
        {
            $this->parser = new Parser();        
        }

        $this->listsNamespace = Config::get('lister.loadListsNamespace');

        $this->functionsNamespace = Config::get('lister.loadFunctionsNamespace');
    }

    protected function getList($item, $column, $config)
    {
        foreach ($this->listsNamespace as $name)
        {
            $typeName  = isset($config['type']) ? ucfirst($config['type']).'List' : 'CommonList';
            $className = $name.$typeName;

            if (class_exists($className))
            {
                return (new $className())->make($item, $column, $config);
            }
        }

        throw new \InvalidArgumentException("It doesn't have any '{$typeName}' class exists");
    }

    protected function getFunction($item, $rule)
    {
        $data = [
            'item' => $item,
            'rule' => $rule
        ];

        foreach ($this->functionsNamespace as $name)
        {
            $typeName  = ucfirst($rule).'Function';
            $className = $name.$typeName;

            if (class_exists($className))
            {
                return (new $className())->make($data);
            }
        }

        throw new \InvalidArgumentException("It doesn't have any '{$typeName}' class exists");
    }

    protected function combineLists($item)
    {
        $content = '';

        foreach ($this->data['listConfig'] as $column => $config)
        {
            $content .= $this->getList($item, $column, $config);
        }

        return $content;
    }

    protected function combineFunctions($item)
    {
        $exceptFunction = Config::get('lister.exceptFunction');
        $rules = array_except($this->data['data']['rules'], $exceptFunction);
        
        $content = '<ul>';

        foreach ($rules as $rule => $config)
        {
            if ($config === true)
            {
                $content .= $this->getFunction($item, $rule);
            }
        }

        $content .= '</ul>';

        return $content;
    }

    protected function mainTdWidth()
    {
        $exceptFunction = Config::get('lister.exceptFunction');
        $rules = array_except($this->data['data']['rules'], $exceptFunction);
        
        $rulesCount = array_filter($rules, function($value)
        {
            if ($value === true) return $value;
        });
        
        return (count($rulesCount)+1) * 50 .'px';

    }

}