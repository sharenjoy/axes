<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Sharenjoy\Customer\Models\Customer;
use Theme;

class CustomerSimpleForm extends FormAbstract implements FormInterface {

    public function make(array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control typeahead';
        $data['data-remote'] = route('customerFilter')."?query=%QUERY";
        $data['data-template'] = "<div class='thumb-entry'><span class='image'><img src='{{img}}' width=40 height=40 /></span><span class='text'><strong>{{value}} {{sn}}</strong><em>{{text}}</em></span></div>";

        $value = $data['value'];

        if ($value)
        {
            $customer = Customer::find($value);
            $data['value'] = $customer->name;
        }

        $data['name'] = '';

        $attributes = $this->attributes($data);
        
        $form = '<div class="customer-field"><input type="text"'.$attributes.'><input type="hidden" id="customer_id" name="customer_id" value="'.$value.'"></div>';

        Theme::asset()->add('typeahead', 'packages/sharenjoy/cmsharenjoy/js/typeahead.min.js');

        Theme::asset()->writeScript('customersimpleform-script', '
            $(function() {

                $(".typeahead")
                // .on("typeahead:initialized", function($e) {
                //     console.log("initialized");
                // })
                // .on("typeahead:opened", function ($e) {
                //     console.log("opened");
                // })
                // .on("typeahead:closed", function($e) {
                //     console.log("closed");
                // })
                .on("typeahead:selected", function ($e, datum) {
                    // console.log("autocompleted");
                    // console.log(datum);
                    $("#customer_id").val(datum.id);
                });
                
                $(".customer-field input[type=text]").on("keyup", function(e) {
                    if ($(this).val() == "") {
                        $("#customer_id").val("");
                    }
                });
            });
        ');
        
        return $form;
    }

}
