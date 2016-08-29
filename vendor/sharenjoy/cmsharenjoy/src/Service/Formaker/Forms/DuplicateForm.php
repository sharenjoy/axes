<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Formaker, Form, Theme;

class DuplicateForm extends FormAbstract implements FormInterface {

    public function make(Array $data)
    {
        // dd($data);
        if ( ! isset($data['others']['setting']['columns']))
        {
            throw new \InvalidArgumentException("There is no 'columns' argument.");
        }

        $fields = '';

        if (count($data['value']))
        {
            foreach ($data['value'] as $key => $value)
            {
                $fields .= '<div class="toclone"><div class="row">';
                foreach ($data['others']['setting']['columns'] as $columnName => $columnItem)
                {
                    $columnItem['name'] = $data['name'].'['.$columnName.']';
                    $columnItem['value'] = $value[$columnName];
                    $columnItem['label-class'] = 'col-md-12';
                    $columnItem['inner-div-class'] = 'col-md-12';
                    $columnItem['duplicate-inner-div-class'] = isset($columnItem['duplicate-inner-div-class']) ? $columnItem['duplicate-inner-div-class'] : 'col-md-12';
                    $fields .= '<div class="'.$columnItem['duplicate-inner-div-class'].'">'.Formaker::$columnName($columnItem).'</div>';
                }
                $fields .= '</div>';
                
                $fields .= '<div class="row"><div class="col-md-12">';
                $fields .= '<div class="main-clone-button pull-left">';
                $fields .= Form::button(pick_trans('buttons.clone'), ['class'=>'btn btn-xs btn-blue clone']);
                $fields .= '</div>';
                $fields .= '<div class="main-clone-button pull-left">';
                $fields .= Form::button(pick_trans('buttons.delete'), ['class'=>'btn btn-xs btn-danger delete']);
                $fields .= '</div>';
                $fields .= '</div></div><div class="clearfix visible-xs-block"></div><hr></div>';
            }
        }
        else
        {
            $fields .= '<div class="toclone"><div class="row">';
            foreach ($data['others']['setting']['columns'] as $columnName => $columnItem)
            {
                $columnItem['name'] = $data['name'].'['.$columnName.']';
                $columnItem['label-class'] = 'col-md-12';
                $columnItem['inner-div-class'] = 'col-md-12';
                $columnItem['duplicate-inner-div-class'] = isset($columnItem['duplicate-inner-div-class']) ? $columnItem['duplicate-inner-div-class'] : 'col-md-12';
                $fields .= '<div class="'.$columnItem['duplicate-inner-div-class'].'">'.Formaker::$columnName($columnItem).'</div>';
            }
            $fields .= '</div>';
            
            $fields .= '<div class="row"><div class="col-md-12">';
            $fields .= '<div class="main-clone-button pull-left">';
            $fields .= Form::button(pick_trans('buttons.clone'), ['class'=>'btn btn-xs btn-blue clone']);
            $fields .= '</div>';
            $fields .= '<div class="main-clone-button pull-left">';
            $fields .= Form::button(pick_trans('buttons.delete'), ['class'=>'btn btn-xs btn-danger delete']);
            $fields .= '</div>';
            $fields .= '</div></div><div class="clearfix visible-xs-block"></div><hr></div>';
        }

        // $data['class'] = array_get($data, 'others.setting.args.class') ?: 
        //                  'form-control tagsinput';

        // $attributes = $this->attributes($data);
        
        $form = $fields;

        Formaker::dummy([
            'label-class'     => isset($data['others']['setting']['label-class'])
                                    ? $data['others']['setting']['label-class']
                                    : $data['others']['config']['label-class'],
            'inner-div-class' => isset($data['others']['setting']['inner-div-class'])
                                    ? $data['others']['setting']['inner-div-class']
                                    : $data['others']['config']['inner-div-class'],
        ]);

        // To add the asset of package to View
        set_package_asset_to_view('cloneya');
        set_package_asset_to_view('jquery-confirm');
        set_package_asset_to_view('ladda-bootstrap');

        Theme::asset()->writeScript('duplicateform-script', '
            $(function() {

                $("#clone-section")
                  .cloneya()
                  .on("clone_before_clone", function(event, toclone) {
                      // do something
                  })
                  .on("clone_after_clone", function(event, toclone, newclone) {
                      // do something   
                  })
                  .on("clone_before_append", function(event, toclone, newclone) {
                      $(newclone).css("display", "none");
                      $(toclone).fadeOut("fast", function() {
                          $(this).fadeIn("fast");
                      });
                  })
                  .on("clone_after_append", function(event, toclone, newclone) {
                      $(newclone).slideToggle();
                  })
                  // we remove the original binding, the call to remove is also gone
                  .off("clone_before_delete")
                  // we add our own, so make sure to remove the element
                  .on("clone_before_delete", function(event, clone) {
                      $.confirm({
                          // title: "{{pick_trans("warning")}}!!!",
                          text: "確定要刪除嗎？",
                          confirm: function() {

                            $(clone).slideToggle("slow", function() {
                              $(this).remove();
                            });

                            toastr.success(result.message, "成功", opts);

                          },
                          cancel: function() {
                              // nothing to do
                          },
                          confirmButton: "是",
                          cancelButton: "否",
                          confirmButtonClass: "btn-danger",
                          cancelButtonClass: "btn-default"
                      });
                  })
                  .on("clone_after_delete", function(event) {
                      // do something;
                  });

            });
        ');
        
        return $form;
    }

}