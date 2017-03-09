<?php namespace Sharenjoy\Cmsharenjoy\Service\Lister;

use Sharenjoy\Cmsharenjoy\Service\Lister\Templates\DefaultTemplate;
use Config;

class Lister extends ListerAbstract implements ListerInterface {

    /**
     * Make the list templates
     * @param array $items
     * @param array $listConfig
     * @param array $data
     * @param string $lister
     */
    public function make($items, $listConfig = array(), $data = array(), $lister = 'default')
    {
        switch ($lister)
        {
            case 'default':
                $config = Config::get('lister.default');
                $template = new DefaultTemplate();
                break;
            case 'grid':
                $config = Config::get('lister.grid');
                $template = new GridTemplate();
                break;
        }

        $data = [
            'listConfig' => $listConfig,
            'items'      => $items,
            'data'       => $data,
            'config'     => $config,
        ];

        return $template->make($data);
    }

}
