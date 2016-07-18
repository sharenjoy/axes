<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Templates;

use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateAbstract;
use Sharenjoy\Cmsharenjoy\Service\Formaker\Templates\TemplateInterface;

class InvisibleTemplate extends TemplateAbstract implements TemplateInterface {

    protected $data;
    
    protected $template = '<div class="display:none">
                               {field}
                           </div>';

    public function make(Array $data)
    {
        $this->data = $data;

        return $this->parser->parse($this->template, $data);
    }

}