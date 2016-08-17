<?php

return [
    
    /*
     * --------------------------------------------------------------------------
     *  How to use
     * --------------------------------------------------------------------------
     *
     * // The attrubutes can be allowed the following
     * value, type, help, placeholder, label, label-inner, args
     * label-class, error-class, help-class, inner-div, outer-div
     * input, filter, category, option, method, relation, pleaseSelect
     * 
     * 
     * {{Formaker::title()}}
     * {{Formaker::email()}}
     * {{Formaker::url()}}
     * {{Formaker::description(['value'=>'This is value'])}}
     * {{Formaker::description(['type'=>'wysiwyg-simple'])}}
     * {{Formaker::tag(['help'=>'This is tag', 'placeholder'=>'You can use "," to sperate every tag'])}}
     * {{Formaker::name(['args'=>['class'=>'options', 'id'=>'name'], 'outer-div' => ['class'=>'form-group', 'id'=>'app'], 'inner-div' => ['class'=>'col-md-5']])}}
     * {{Formaker::avatar(['type'=>'image', 'size'=>'180x180'])}}
     * 
     * {{Formaker::status(['type'=>'checkbox', 'value'=>'1,2'])}}
     * 
     * // If set key that the name is input the means the data form title input
     * {{Formaker::content(['input'=>'title'])}}
     *
     * // If set the key that the name is filter means will filter from the value
     * {{Formaker::keyword(['filter'=>'title,title_jp,description'])}}
     *
     * // The following setting is for select element option
     * {{Formaker::category_id([category'=>'News'])}}
     * {{Formaker::category_id([category'=>'News', 'pleaseSelect'=>true])}}
     * {{Formaker::category(['type'=>'category', 'category'=>'Product'])}}
     * 
     * // This will triger the method of Model $this->model->categoryLists() and return what ever you set;
     * {{Formaker::category(['type'=>'select', 'method'=>'category_lists'])}}
     * // only different from above example is the relation well pass through the model id to method
     * {{Formaker::category(['type'=>'select', 'relation'=>'fieldCompanies'])}}
     * 
     * {{Formaker::delivery_time_zone_id(['type'=>'select', 'option'=>'delivery_time_zone'])}}
     * {{Formaker::language(['type'=>'select', 'value'=>'tw', 'option'=>['tw'=>'中文', 'en'=>'英文']])}}
     *
     * {{Formaker::delivery_time_zone_id(['type'=>'select', 'preview'=>[], 'create'=>'deny', 'update'=>['args'=>['readonly'=>'readonly']]])}}
     * 
     * 
     */
    
    /*
     * --------------------------------------------------------------------------
     *  Default Formaker Driver
     * --------------------------------------------------------------------------
     * 
     *  This option controls the formaker driver that will be utilized.
     * 
     *  Supported: "TwitterBootstrapV3"
     * 
    */

    // back-end
    'driver-back'  => 'TwitterBootstrapV3',

    // fore-end
    'driver-front' => 'TwitterBootstrapV3',


    'loadFormsNamespace' => [
        'Sharenjoy\Cmsharenjoy\Service\Formaker\Forms\\',
    ],


    'backEnd' => [
        'TwitterBootstrapV3' => [
            'label-class'     => 'col-sm-2 control-label',
            'error-class'     => 'has-error',
            'help-class'      => 'help-block',
            'input-class'     => 'form-control',
            'inner-div-class' => 'col-sm-5',
            'outer-div-class' => 'form-group',
            'filter-class'    => 'list-filter col-md-3 col-sm-6',
        ],
    ],


    'frontEnd' => [
        'TwitterBootstrapV3' => [
        ],
    ],

    /**
     * Frequent input names can map
     * to their respective input types.
     *
     * This way, you may do FormField::description()
     * and it'll know to automatically set it as a textarea.
     * Otherwise, do FormField::thing(['type' = 'textarea'])
     *
     */
    'commonInputsLookup' =>
    [
        // For email
        'email'                 => 'email',
        'emailAddress'          => 'email',
        
        // For textarea
        'description'           => 'textarea',
        'bio'                   => 'textarea',
        'body'                  => 'textarea',
        'notes'                 => 'textarea',
        
        // For wysiwyg
        'content'               => 'wysiwygAdvanced',
        
        // For password
        'password'              => 'password',
        'passwordConfirmation'  => 'password',
        'password_confirmation' => 'password',
        
        // For tag
        'tag'                   => 'tag',
        'related'               => 'tag',
        
        // For select
        'status'                => 'select',
        
        // For url
        'url'                   => 'url',
        'link'                  => 'url',
        
        // For image
        'img'                   => 'image',
        'img1'                  => 'image',
        'img2'                  => 'image',
        'img3'                  => 'image',
        'img4'                  => 'image',
        'img5'                  => 'image',
        'image'                 => 'image',
        'imagename'             => 'image',
        'avatar'                => 'image',

        // For file
        'file'                  => 'file',
        'filename'              => 'file',

        // For album
        'album'                 => 'album',
        'filealbum'             => 'album',

        // For category
        'category_id'           => 'category',

        // For customer
        'customer_id'           => 'customer',
        'customer'              => 'customer',

        // For employee
        'employee_id'           => 'employee',
        'employee'              => 'employee',
    ],

];
