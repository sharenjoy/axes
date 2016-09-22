<?php

/**
 * The application configuration file, used to setup 
 * globally used values throughout the application
 */
return [

    /**
     * The key defines the url of
     * access of the main admin area
     */
    'access_url' => 'admin',

    /**
     * This is the namespace of modules
     * It's into the app folder
     */
    'moduleNamespace' => 'Modules\\',

    /**
     * The array of language
     */
    'locales' => [
        'zh-TW' => '繁體中文',
        // 'en'    => 'English',
        // 'zh-CN' => '簡體中文',
        // 'ja'    => '日文',
    ],

    /**
     * This is default language setting
     */
    'language_default' => env('APP_LANGUAGE_DEFAULT', null),

    'language' => [
        'tw' => [
            'icon'  => 'flag-tw.png',
            'title' => '繁體中文',
        ],
        'en' => [
            'icon'  => 'flag-uk.png',
            'title' => 'English',
        ],
        'jp' => [
            'icon'  => 'flag-jp.png',
            'title' => '日本語',
        ],
    ],

    /**
     * The path and size of logo
     */
    'logo' => [
        'favicon' => [
            'path' => 'images/favicon.ico',
            'width' => '16',
        ],
        'login' => [
            'path' => 'images/logo.png',
            'width' => '160',
        ],
        'index' => [
            'path' => 'images/logo.png',
            'width' => '100',
        ]
    ],

    /**
     * The common directory of layout
     */
    'commonLayoutDirectory' => 'common',

    /**
     * The item amount of page
     */
    'paginationCount' => 15,

    /**
     * The menu items shown at the top
     * and side of the application
     */
    'menu_items' => [
        'carousel' => [
            'name' => 'cmsharenjoy.menu.carousel',
            'icon' => 'entypo-video',
        ],
        'post' => [
            'name' => 'cmsharenjoy.menu.post',
            'icon' => 'entypo-doc-text',
        ],
        'category' => [
            'name' =>'cmsharenjoy.menu.category',
            'icon' =>'entypo-share',
            'sub'  => [
                'category?category=product' => [
                    'name' => 'cmsharenjoy.menu.product_category'
                ],
            ]
        ],
        'tag' => [
            'name' => 'cmsharenjoy.menu.tag',
            'icon' => 'entypo-tag',
        ],
        'filer' => [
            'name' => 'cmsharenjoy.menu.file',
            'icon' => 'entypo-box',
        ],
        'user' => [
            'name' => 'cmsharenjoy.menu.user',
            'icon' => 'entypo-key',
        ],
        'setting' => [
            'name' => 'cmsharenjoy.menu.setting',
            'icon' => 'entypo-cog',
        ]
    ],
    
    /**
     * This configuration file is used to setup 
     * the initial user and seed to the database
     */
    'administrator' => [
        'email'         => 'example@example.com',
        'name'          => 'Example',
        'password'      => 'password',
        'phone'         => '0939999999',
    ],

    'autoActivable' => true,

];
