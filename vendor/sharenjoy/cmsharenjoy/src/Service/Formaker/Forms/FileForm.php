<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

class FileForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        $otherSetting = $data['others'];
        $name         = $data['name'];
        $value        = $data['value'];

        $select_image  = pick_trans('buttons.select_file');
        $change        = pick_trans('buttons.change');
        $remove        = pick_trans('buttons.remove');
        $form          = <<<EOE
            <div class="fileinput fileinput-new file-pick-open-manager">
                <div data-type="file" class="fileinput-new thumbnail" id="file-{$name}" style="width: 100px; height: 100px;">
EOE;
        $form         .= '<input type="hidden" name="'.$name.'" value="'.$value.'">';
        $form         .= <<<EOE
                    <img src="http://placehold.it/100&text=FILE">
                </div>
                <div>
                    <span class="btn btn-white btn-file">
                        <span class="fileinput-new">{$select_image}</span>
                        <span class="fileinput-exists">{$change}</span>
                    </span>
                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">{$remove}</a>
                </div>
            </div>
EOE;

        set_package_asset_to_view('file-picker-reload');
        
        return $form;
    }

}
