<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TwitterBootstrapV3;

use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\BlockTemplate;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateAbstract;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateInterface;
use Session;

class CommonTemplate extends TemplateAbstract implements TemplateInterface {
    
    protected $data;

    protected $template = '<div class="{outer-class}"{style}>
                               {label-outer}
                               <div class="{inner-class}">
                                   {label-inner}
                                   {field}
                                   {error}
                                   {help}
                               </div>
                           </div>';

    public function make(Array $data)
    {
        $this->data = $data;

        if (isset($data['setting']['label-inner']) && $data['setting']['label-inner'] === true)
        {
            $data['label-outer'] = '';
            $data['label-inner'] = $this->label();
        }
        else 
        {
            $data['label-outer'] = $this->label();
            $data['label-inner'] = '';
        }

        $data['help']  = $this->help();
        $data['error'] = $this->error();

        $data['outer-class'] = $this->getSettingOrConfig('outer-div-class');
        $data['inner-class'] = $this->getSettingOrConfig('inner-div-class');
        $data['style'] = $this->data['type'] == 'hidden' ? ' style="display:none"' : '';

        if ( ! is_null($data['error']))
        {
            $data['outer-class'] .= ' '.$this->getSettingOrConfig('error-class');
        }
        
        return $this->parser->parse($this->template, $data);
    }

    protected function label()
    {
        $data = [
            'tag' => 'label',
            'attributes' => [
                'for'   => $this->data['name'],
                'class' => $this->getSettingOrConfig('label-class')
            ],
            'content' => array_get($this->data['setting'], 'label') ?: $this->prettifyFieldName()
        ];

        return $this->createBlock($data);
    }

    protected function help()
    {
        if ($this->data['help'])
        {
            $data = [
                'tag' => 'span',
                'attributes' => [
                    'class' => $this->getSettingOrConfig('help-class')
                ],
                'content' => $this->data['help']
            ];

            return $this->createBlock($data);
        }
    }

    protected function error()
    {
        $name   = $this->data['name'];

        $errors = Session::get('sharenjoy.validation.errors');

        if (isset($errors) && $errors->has($name))
        {
            $data = [
                'tag' => 'span',
                'attributes' => [
                    'class' => $this->getSettingOrConfig('error-class')
                ],
                'content' => $errors->first($name)
            ];

            return $this->createBlock($data);
        }
    }

    protected function createBlock($data)
    {
        $obj = new BlockTemplate();
        
        return $obj->make($data);
    }

}