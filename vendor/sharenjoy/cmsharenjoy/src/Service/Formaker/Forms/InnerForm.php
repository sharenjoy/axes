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
                $rwd = isset($args['rwd-class']) ? $args['rwd-class'] : $data['others']['setting']['rwd-class'];
                $form .= '<div class="'.$rwd.'">'.$formaker->{$field}($args).'</div>';
            }
        }

        $form .= '</div>';
        
        return $form;
    }

}