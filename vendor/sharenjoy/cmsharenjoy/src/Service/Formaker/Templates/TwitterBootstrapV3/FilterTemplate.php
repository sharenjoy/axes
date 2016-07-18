<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TwitterBootstrapV3;

use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\BlockTemplate;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateAbstract;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateInterface;

class FilterTemplate extends TemplateAbstract implements TemplateInterface {

    protected $data;
    
    protected $template = '<div class="{filter-class}"{style}>
                               {label}
                               {field}
                               {help}
                           </div>';

    public function make(Array $data)
    {
        $this->data = $data;

        $data['filter-class'] = $this->getSettingOrConfig('filter-class');
        $data['style'] = $this->data['type'] == 'hidden' ? ' style="display:none"' : '';
        
        $data['label'] = $this->label();

        return $this->parser->parse($this->template, $data);
    }

    protected function label()
    {
        $data = [
            'tag' => 'label',
            'attributes' => [
                'for'   => $this->data['name'],
                'class' => $this->getSettingOrConfig('filter-label-class'),
            ],
            'content' => array_get($this->data['setting'], 'label') ?: $this->prettifyFieldName()
        ];

        return (new BlockTemplate())->make($data);
    }

}