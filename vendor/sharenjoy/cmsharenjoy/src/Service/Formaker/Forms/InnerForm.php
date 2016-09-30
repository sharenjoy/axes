<?php

namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Sharenjoy\Cmsharenjoy\Service\Formaker\TwitterBootstrapV3;

class InnerForm extends FormAbstract implements FormInterface
{
    public function make(Array $data)
    {
        $form = '<div class="row">';

        if (isset($data['others']['setting']['columns'])) {
            
            $formaker = new TwitterBootstrapV3('backEnd');

            foreach ($data['others']['setting']['columns'] as $field => $args) {
                $form .= '<div class="'.$data['others']['setting']['rwd-class'].'">'.$formaker->{$field}($args).'</div>';
            }
        }

        $form .= '</div>';
        
        return $form;
    }

}