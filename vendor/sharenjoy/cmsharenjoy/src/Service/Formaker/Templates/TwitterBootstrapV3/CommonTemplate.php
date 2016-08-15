<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TwitterBootstrapV3;

use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\BlockTemplate;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateAbstract;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateInterface;
use Session;

class CommonTemplate extends TemplateAbstract implements TemplateInterface {
    
    protected $data;

    protected $template = '<div{outer-div}{style}>
                               {label-outer}
                               <div{inner-div}>
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

        if (! isset($data['setting']['outer-div']['class'])) {
            $data['setting']['outer-div']['class'] = $data['config']['outer-div-class'];
        }
        if (! is_null($data['error'])) {
            $data['setting']['outer-div']['class'] .= ' '.$this->getSettingOrConfig('error-class');
        }
        $data['outer-div'] = $this->attributes($data['setting']['outer-div']);

        if (! isset($data['setting']['inner-div']['class'])) {
            $data['setting']['inner-div']['class'] = $data['config']['inner-div-class'];
        }
        $data['inner-div'] = $this->attributes($data['setting']['inner-div']);

        $data['style'] = $this->data['type'] == 'hidden' ? ' style="display:none"' : '';
        
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