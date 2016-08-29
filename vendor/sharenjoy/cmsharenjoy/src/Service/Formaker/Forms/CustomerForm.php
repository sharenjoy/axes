<?php namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Sharenjoy\Customer\Models\Customer;
use Theme;

class CustomerForm extends FormAbstract implements FormInterface {

    public function make(array $data)
    {
        $data['class'] = array_get($data, 'others.setting.args.class') ?: 
                         'form-control typeahead';
        $data['data-remote'] = route('customerFilter')."?query=%QUERY";
        $data['data-template'] = "<div class='thumb-entry'><span class='image'><img src='{{img}}' width=40 height=40 /></span><span class='text'><strong>{{value}} {{sn}}</strong><em>{{text}}</em></span></div>";

        $value = $data['value'];
        $buttonIcon = 'entypo-search';
        $popoverTitle = '';
        $popoverContent = '';

        if ($value)
        {
            $customer = Customer::find($value);
            $data['value'] = $customer->name;
            $buttonIcon = 'entypo-popup';
            $popoverTitle = $customer->name.' '.$customer->sn;
            $popoverContent = $customer->name;
        }

        $data['name'] = 'customer_name';

        $attributes = $this->attributes($data);
        
        $form = '<div class="customer-field"><input type="text"'.$attributes.'><input type="hidden" id="customer_id" name="customer_id" value="'.$value.'"><button type="button" class="btn" id="popoverCustomer" style="position: absolute;right: 7px;top: 1px;border: 0px none;background: none repeat scroll 0% 0% transparent;color: #737881;font-size: 16px;opacity: 0.7;transition: all 300ms ease-in-out 0s;"><i class="'.$buttonIcon.'"></i></button></div>';
        $form .= '<div id="popoverCustomerHiddenTitle" style="display: none;">'.$popoverTitle.'</div>
                  <div id="popoverCustomerHiddenContent" style="display: none;">'.$popoverContent.'</div>';

        Theme::asset()->add('typeahead', 'packages/sharenjoy/cmsharenjoy/js/typeahead.min.js');

        Theme::asset()->writeScript('customerform-script', '
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
                    $("#popoverCustomerHiddenTitle").html(datum.value+" "+datum.sn);
                    $("#popoverCustomerHiddenContent").html(datum.value);
                    $(".customer-field button i").fadeOut("fast", function(){
                        $(this).attr("class", "entypo-popup");
                    }).fadeIn("slow");
                    $("#customer_id").val(datum.id);
                });
                
                $(".customer-field input[type=text]").on("keyup", function(e) {
                    if ($(this).val() == "") {
                        $("#customer_id").val("");
                        $(".customer-field button i").fadeOut("fast", function(){
                            $(this).attr("class", "entypo-search");
                        }).fadeIn("slow");
                        $("#popoverCustomerHiddenTitle").html("");
                        $("#popoverCustomerHiddenContent").html("");
                    }
                });

                $("#popoverCustomer").popover({
                    html: true,
                    trigger: "hover",
                    placement: "auto",
                    container: "body",
                    content: function() {
                      return $("#popoverCustomerHiddenContent").html();
                    },
                    title: function() {
                      return $("#popoverCustomerHiddenTitle").html();
                    }
                });
            });
        ');
        
        return $form;
    }

}
